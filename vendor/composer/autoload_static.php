<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce9c6506248a8e4486050887d70dddf5
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Facebook\\WebDriver\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Facebook\\WebDriver\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/webdriver/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce9c6506248a8e4486050887d70dddf5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce9c6506248a8e4486050887d70dddf5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitce9c6506248a8e4486050887d70dddf5::$classMap;

        }, null, ClassLoader::class);
    }
}
