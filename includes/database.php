<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'sandwich';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erreur connexion DB : " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>