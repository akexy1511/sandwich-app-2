<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Paiement;
use App\Models\Sandwich;

class PaiementController extends Controller
{
    public function index($commandeId)
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        $db = Database::db();

        // Vérifier que la commande appartient à l’utilisateur
        $stmt = $db->prepare("
            SELECT * FROM commandes
            WHERE id_commande = :id AND id_utilisateur = :uid
        ");

        $stmt->execute([
            'id' => $commandeId,
            'uid' => $_SESSION['user_id']
        ]);

        $order = $stmt->fetch();

        if (!$order) {
            $_SESSION['message'] = "Commande introuvable.";
            return header("Location: /commandes");
        }

        // Charger sandwich.json pour prix
        $sandwiches = Sandwich::all();
        $key = strtolower($order['nom']);

        $price = $sandwiches[$key]['price'] ?? 5.00;

        $this->view('paiement/index', [
            'order' => $order,
            'price' => $price
        ]);
    }

    public function process()
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return header("Location: /commandes");
        }

        $orderId = intval($_POST['order_id'] ?? 0);
        $method  = $_POST['payment_method'] ?? '';

        if (!$orderId || !$method) {
            $_SESSION['message'] = "Méthode de paiement invalide.";
            return header("Location: /commandes");
        }

        $db = Database::db();

        // Vérifier commande
        $stmt = $db->prepare("
            SELECT * FROM commandes
            WHERE id_commande = :id AND id_utilisateur = :uid
        ");

        $stmt->execute([
            'id' => $orderId,
            'uid' => $_SESSION['user_id']
        ]);

        $order = $stmt->fetch();

        if (!$order) {
            $_SESSION['message'] = "Commande introuvable.";
            return header("Location: /commandes");
        }

        // Prix
        $sandwiches = Sandwich::all();
        $key = strtolower($order['nom']);
        $amount = $sandwiches[$key]['price'] ?? 5.00;

        /* ---------------------------
           Traitement du paiement
        ---------------------------- */

        if ($method === 'card') {
            // simulation
            if (empty($_POST['card_number']) ||
                empty($_POST['expiry_date']) ||
                empty($_POST['cvv']))
            {
                $_SESSION['message'] = "Détails de carte incomplets.";
                return header("Location: /paiement/$orderId");
            }
        }

        // Tous les autres modes = validés automatiquement
        $transactionId = Paiement::createTransaction($_SESSION['user_id'], $amount);

        Paiement::linkToCommande($orderId, $transactionId);

        $_SESSION['message'] = "Paiement effectué avec succès.";
        return header("Location: /commandes");
    }
}