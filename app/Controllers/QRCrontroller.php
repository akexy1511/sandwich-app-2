<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRController extends Controller
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        $db = Database::db();

        // Récupération de la commande du jour
        $today = date('Y-m-d');

        $stmt = $db->prepare("
            SELECT nom, jour 
            FROM commandes 
            WHERE id_utilisateur = :uid 
            AND date_de_commande = :today
            LIMIT 1
        ");

        $stmt->execute([
            'uid' => $_SESSION['user_id'],
            'today' => $today
        ]);

        $order = $stmt->fetch();

        if (!$order) {
            $_SESSION['message'] = "Aucune commande aujourd'hui.";
            return header("Location: /commandes");
        }

        // Contenu du QR
        $content = "Commande du jour : {$order['nom']} ({$order['jour']})";

        // Dossier temp
        $dir = __DIR__ . '/../../public/temp/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = md5(uniqid('', true)) . '.png';
        $filepath = $dir . $filename;

        // Génération QR
        $qr = QrCode::create($content)
            ->setSize(300);

        $writer = new PngWriter();
        $result = $writer->write($qr);
        $result->saveToFile($filepath);

        // URL publique
        $publicUrl = "/temp/" . $filename;

        $this->view('qr/index', [
            'order' => $order,
            'qr' => $publicUrl
        ]);
    }
}