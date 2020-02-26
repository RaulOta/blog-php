<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteb84ac228e15245b62cd9510c39d7903
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
            $loader->prefixLengthsPsr4 = ComposerStaticIniteb84ac228e15245b62cd9510c39d7903::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteb84ac228e15245b62cd9510c39d7903::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}