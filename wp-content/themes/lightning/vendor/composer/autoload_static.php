<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d57e5f189cf68783152ffdb6fae600a
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VektorInc\\VK_Helpers\\' => 21,
            'VektorInc\\VK_Font_Awesome_Versions\\' => 35,
            'VektorInc\\VK_Color_Palette_Manager\\' => 35,
            'VektorInc\\VK_Breadcrumb\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VektorInc\\VK_Helpers\\' => 
        array (
            0 => __DIR__ . '/..' . '/vektor-inc/vk-helpers/src',
        ),
        'VektorInc\\VK_Font_Awesome_Versions\\' => 
        array (
            0 => __DIR__ . '/..' . '/vektor-inc/font-awesome-versions/src',
        ),
        'VektorInc\\VK_Color_Palette_Manager\\' => 
        array (
            0 => __DIR__ . '/..' . '/vektor-inc/vk-color-palette-manager/src',
        ),
        'VektorInc\\VK_Breadcrumb\\' => 
        array (
            0 => __DIR__ . '/..' . '/vektor-inc/vk-breadcrumb/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'VektorInc\\VK_Breadcrumb\\VkBreadcrumb' => __DIR__ . '/..' . '/vektor-inc/vk-breadcrumb/src/VkBreadcrumb.php',
        'VektorInc\\VK_Color_Palette_Manager\\VkColorPaletteManager' => __DIR__ . '/..' . '/vektor-inc/vk-color-palette-manager/src/VkColorPaletteManager.php',
        'VektorInc\\VK_Font_Awesome_Versions\\VkFontAwesomeVersions' => __DIR__ . '/..' . '/vektor-inc/font-awesome-versions/src/VkFontAwesomeVersions.php',
        'VektorInc\\VK_Helpers\\VkHelpers' => __DIR__ . '/..' . '/vektor-inc/vk-helpers/src/VkHelpers.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3d57e5f189cf68783152ffdb6fae600a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3d57e5f189cf68783152ffdb6fae600a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3d57e5f189cf68783152ffdb6fae600a::$classMap;

        }, null, ClassLoader::class);
    }
}
