<?php

namespace App\Helpers;

class Auth
{
    static $loginUrl = 'auth/signin';

    static function check()
    {
        session_start();
        if (isset($_SESSION["user"])) {
            return $_SESSION["user"];
        } else {
            HTTP::redirect(static::$loginUrl, "login=false");
        }
    }
    static function allowTo($url, ...$roles)
    {
        $user = static::check();
        if (!in_array($user->role, $roles)) {
            HTTP::redirect($url, "unauthorized=true");
        }
        return;
    }
}
