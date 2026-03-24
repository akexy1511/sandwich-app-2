<?php
use App\Core\Database;

session_start([
    'cookie_httponly' => true,
    'use_strict_mode' => true,
    'cookie_secure' => false,
]);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

Database::init();
