<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite35f7654f369329253453eefe0f0116e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SquareConnect\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SquareConnect\\' => 
        array (
            0 => __DIR__ . '/..' . '/square/connect/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite35f7654f369329253453eefe0f0116e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite35f7654f369329253453eefe0f0116e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
