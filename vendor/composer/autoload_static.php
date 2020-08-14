<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfee499ba8792e168bceceec81c2ce93a
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HPR\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HPR\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'HPR\\HappyForms_Recaptcha' => __DIR__ . '/../..' . '/includes/class-happyforms-recaptcha.php',
        'HPR\\HappyForms_Recaptcha_Admin' => __DIR__ . '/../..' . '/includes/class-happyforms-recaptcha-admin.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfee499ba8792e168bceceec81c2ce93a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfee499ba8792e168bceceec81c2ce93a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfee499ba8792e168bceceec81c2ce93a::$classMap;

        }, null, ClassLoader::class);
    }
}
