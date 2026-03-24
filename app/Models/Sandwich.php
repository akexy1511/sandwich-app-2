<?php
namespace App\Models;

class Sandwich
{
    public static function all()
    {
        $file = __DIR__ . '/../../sandwiches.json';

        if (!file_exists($file)) return [];

        $data = json_decode(file_get_contents($file), true);
        return $data ?? [];
    }

    public static function get($name)
    {
        $name = strtolower($name);
        $all = self::all();

        return $all[$name] ?? null;
    }
}