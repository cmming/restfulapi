<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbe9f46cdb9e673df9ebce83af9b31fc4
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbe9f46cdb9e673df9ebce83af9b31fc4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbe9f46cdb9e673df9ebce83af9b31fc4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
