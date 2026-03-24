
<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Core\Router;

$router = new Router();

// Routes publiques
$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@processLogin');
$router->get('/signup', 'AuthController@signup');
$router->post('/signup', 'AuthController@processSignup');
$router->get('/logout', 'AuthController@logout');

// Routes utilisateur
$router->get('/commandes', 'CommandeController@index');
$router->post('/commandes/create', 'CommandeController@create');
$router->get('/sandwich/{name}', 'SandwichController@detail');

// Paiement
$router->get('/paiement/{id}', 'PaiementController@index');
$router->post('/paiement/process', 'PaiementController@process');

// QR Code
$router->get('/qr', 'QRController@index');

// Feedback / problème
$router->get('/probleme', 'ReportController@index');
$router->post('/probleme', 'ReportController@send');

// DASHBOARD ADMIN
$router->get('/admin', 'AdminController@index');

// GESTION UTILISATEURS
$router->get('/admin/users', 'AdminController@users');
$router->post('/admin/users/delete', 'AdminController@deleteUser');

// GESTION COMMANDES
$router->get('/admin/commandes', 'AdminController@commandes');
$router->get('/admin/sandwichs', 'AdminController@sandwichs');
$router->post('/admin/sandwichs/update', 'AdminController@updateSandwich');

// GESTION SANDWICHS
$router->get('/admin/sandwichs', 'AdminController@sandwichs');
$router->post('/admin/sandwichs/update', 'AdminController@updateSandwich');

// Lancement du routeur
$router->dispatch();
