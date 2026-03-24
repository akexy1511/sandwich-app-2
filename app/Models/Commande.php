<?php
namespace App\Models;

use App\Core\Database;
use DateTime;

class Commande
{
    public static function getByUser($userId)
    {
        $db = Database::db();

        $sql = "
            SELECT 
                c.id_commande,
                c.jour,
                c.date_de_commande,
                c.nom,
                c.crudites,
                CASE WHEN f.id_commande IS NOT NULL THEN 1 ELSE 0 END AS is_paid
            FROM commandes c
            LEFT JOIN facturation f ON c.id_commande = f.id_commande
            WHERE c.id_utilisateur = :uid
            ORDER BY c.date_de_commande ASC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['uid' => $userId]);

        return $stmt->fetchAll();
    }

    // Logique "modifiable" conservée de ton ancien code
    public static function isModifiable($dateCommande)
    {
        $now = new DateTime();
        $date = DateTime::createFromFormat('Y-m-d', $dateCommande);

        if (!$date) return false;

        // Délai limite = veille 16h
        $deadline = (clone $date)->modify('-1 day')->setTime(16, 0);

        return $now < $deadline;
    }
}