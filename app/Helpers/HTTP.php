<?php

namespace App\Helpers;

class HTTP
{
    static $base = URLROOT;

    static function redirect($path, $query = "")
    {
        $url = static::$base . $path;
        if($query) $url .= "?$query";

        header("location: $url");
        exit();
    }
}
