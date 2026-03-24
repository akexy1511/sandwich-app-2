<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        $userId = $_SESSION['user_id'];

        // Charger commandes utilisateur
        $commandes = Commande::getByUser($userId);

        // Charger sandwiches.json (images + prix)
        $sandwiches = [];
        $json = __DIR__ . '/../../sandwiches.json';

        if (file_exists($json)) {
            $sandwiches = json_decode(file_get_contents($json), true) ?? [];
        }

        $this->view('commandes/index', [
            'commandes' => $commandes,
            'sandwiches' => $sandwiches
        ]);
    }
}
