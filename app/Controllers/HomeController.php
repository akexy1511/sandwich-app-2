<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $sandwiches = [];

        $json = __DIR__ . '/../../sandwiches.json';

        if (file_exists($json)) {
            $content = file_get_contents($json);
            $sandwiches = json_decode($content, true) ?? [];
        }

        $this->view('home/index', [
            'sandwiches' => $sandwiches
        ]);
    }
}