<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitde6dd25c9e82d46262f8b3953749f2c0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitde6dd25c9e82d46262f8b3953749f2c0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitde6dd25c9e82d46262f8b3953749f2c0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
