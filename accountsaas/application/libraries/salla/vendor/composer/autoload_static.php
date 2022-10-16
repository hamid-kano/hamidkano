<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitde98ff3cc8d028ba4ac12d723b47a0bc
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'chillerlan\\Settings\\' => 20,
            'chillerlan\\QRCode\\' => 18,
        ),
        'S' => 
        array (
            'Salla\\ZATCA\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'chillerlan\\Settings\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-settings-container/src',
        ),
        'chillerlan\\QRCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/chillerlan/php-qrcode/src',
        ),
        'Salla\\ZATCA\\' => 
        array (
            0 => __DIR__ . '/..' . '/salla/zatca/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitde98ff3cc8d028ba4ac12d723b47a0bc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitde98ff3cc8d028ba4ac12d723b47a0bc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitde98ff3cc8d028ba4ac12d723b47a0bc::$classMap;

        }, null, ClassLoader::class);
    }
}
