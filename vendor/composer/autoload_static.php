<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Svg\\' => 4,
            'Sabberworm\\CSS\\' => 15,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Masterminds\\' => 12,
        ),
        'F' => 
        array (
            'Fpdf\\' => 5,
            'FontLib\\' => 8,
        ),
        'D' => 
        array (
            'Dompdf\\' => 7,
        ),
        'C' => 
        array (
            'Cpms\\' => 5,
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
            'Adms\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Svg\\' => 
        array (
            0 => __DIR__ . '/..' . '/dompdf/php-svg-lib/src/Svg',
        ),
        'Sabberworm\\CSS\\' => 
        array (
            0 => __DIR__ . '/..' . '/sabberworm/php-css-parser/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Masterminds\\' => 
        array (
            0 => __DIR__ . '/..' . '/masterminds/html5/src',
        ),
        'Fpdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf',
        ),
        'FontLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/dompdf/php-font-lib/src/FontLib',
        ),
        'Dompdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/dompdf/dompdf/src',
        ),
        'Cpms\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/cpms',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Adms\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/adms',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Dompdf\\Cpdf' => __DIR__ . '/..' . '/dompdf/dompdf/lib/Cpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1::$classMap;

        }, null, ClassLoader::class);
    }
}
