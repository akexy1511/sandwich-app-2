<?php
namespace App\Models;

use App\Core\Database;
use PDOException;

class Paiement
{
    public static function createTransaction($userId, $montant)
    {
        $db = Database::db();

        $sql = "
            INSERT INTO transaction (heure, montant, jour_, id_utilisateur)
            VALUES (:heure, :montant, :jour, :uid)
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([
            'heure'   => date('H:i:s'),
            'montant' => $montant,
            'jour'    => date('Y-m-d'),
            'uid'     => $userId
        ]);

        return $db->lastInsertId();
    }

    public static function linkToCommande($commandeId, $transactionId)
    {
        $db = Database::db();

        $sql = "
            INSERT INTO facturation (id_commande, id_transaction)
            VALUES (:cmd, :trans)
        ";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            'cmd'   => $commandeId,
            'trans' => $transactionId
        ]);
    }
}