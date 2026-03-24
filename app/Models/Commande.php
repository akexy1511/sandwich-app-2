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

    public static function create($userId, $sandwich, $crudites, $jours)
    {
        $db = Database::db();
        $sql = "
            INSERT INTO commandes (jour, id_utilisateur, crudites, nom, date_de_commande)
            VALUES (:jour, :uid, :crudites, :nom, :date_cmd)
        ";

        $stmt = $db->prepare($sql);

        $inserted = 0;
        $skipped  = 0;

        foreach ($jours as $raw) {

            if (!str_contains($raw, "\n")) {
                $skipped++;
                continue;
            }

            list($jour, $date) = explode("\n", $raw);

            $d = \DateTime::createFromFormat('d/m/Y', trim($date));
            if (!$d) {
                $skipped++;
                continue;
            }

            $dateSQL = $d->format('Y-m-d');

            try {
                $stmt->execute([
                    ':jour'      => trim($jour),
                    ':uid'       => $userId,
                    ':crudites'  => $crudites,
                    ':nom'       => $sandwich,
                    ':date_cmd'  => $dateSQL,
                ]);

                $inserted++;

            } catch (\PDOException $e) {

                // doublon (contrainte UNIQUE)
                if ($e->getCode() === '23000') {
                    $skipped++;
                    continue;
                }

                error_log("Erreur insertion commande : " . $e->getMessage());
                $skipped++;
            }
        }

        return [
            'inserted' => $inserted,
            'skipped'  => $skipped
        ];
    }
    public static function delete($commandeId, $userId)
    {
        $db = Database::db();

        $sql = "
            DELETE FROM commandes 
            WHERE id_commande = :id 
            AND id_utilisateur = :uid
        ";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            'id'  => $commandeId,
            'uid' => $userId
        ]);
    }
    public static function update($commandeId, $userId, $sandwich, $crudites)
    {
        $db = Database::db();

        $sql = "
            UPDATE commandes
            SET nom = :nom,
                crudites = :crudites
            WHERE id_commande = :id
            AND id_utilisateur = :uid
        ";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            'nom'      => $sandwich,
            'crudites' => $crudites,
            'id'       => $commandeId,
            'uid'      => $userId
        ]);
    }
    
}