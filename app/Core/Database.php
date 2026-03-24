<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $db = null;

    public static function init(): void
    {
        if (self::$db) return;

        try {
            self::$db = new PDO(
                "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die("Erreur connexion DB : " . $e->getMessage());
        }
    }

    public static function db(): PDO
    {
        return self::$db;
    }
}