<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit16d117197d1ded6de0a257aae8b959be
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Endroid\\QrCode\\' => 15,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
        'A' => 
        array (
            'Ademcan\\DinamikQr\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Endroid\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/endroid/qr-code/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
        'Ademcan\\DinamikQr\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit16d117197d1ded6de0a257aae8b959be::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit16d117197d1ded6de0a257aae8b959be::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit16d117197d1ded6de0a257aae8b959be::$classMap;

        }, null, ClassLoader::class);
    }
}
