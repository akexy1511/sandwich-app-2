<?php
namespace App\Core;

class Controller 
{
    protected function view(string $path, array $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../Views/$path.php";
    }
}