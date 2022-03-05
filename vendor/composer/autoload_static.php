<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfc581d7fbb29c75b3e189d7f8ef17293
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfc581d7fbb29c75b3e189d7f8ef17293::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfc581d7fbb29c75b3e189d7f8ef17293::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfc581d7fbb29c75b3e189d7f8ef17293::$classMap;

        }, null, ClassLoader::class);
    }
}
