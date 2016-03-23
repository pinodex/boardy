<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Extension;

use Boardy\Services\Config;

class ExtensionLoader
{
    /**
     * @var string Base directory of extensions
     */
    private static $base;

    /**
     * @var array Array of loaded extensions
     */
    private static $loadedExtensions = [];

    /**
     * Load activated extensions
     */
    public static function load()
    {
        self::$base = ROOT . 'resources/extensions';
        $extensions = Config::get('activatedExtensions', []);

        foreach ($extensions as $extension) {
            if ($entryFile = self::getEntryFile($extension)) {
                include_once $entryFile;
                
                if (class_exists($extension)) {
                    $entryClass = new $extension;
                    $entryClass->load();

                    $loadedExtensions[] = $extension;
                }
            }
        }
    }

    /**
     * Get loaded extensions
     *
     * @return array
     */
    public static function getLoadedExtensions()
    {
        return self::$loadedExtensions;
    }

    /**
     * Get entry file for extension
     *
     * @param string $name Extension name
     *
     * @return string|boolean
     */
    public static function getEntryFile($name)
    {
        // ROOT/extensions/ExtensionName
        $entryDir = sprintf('%s/%s', self::$base, $name);
        // ROOT/extensions/ExtensionName/ExtensionName.php
        $entryFile = sprintf('%s/%s.php', $entryDir, $name);

        if (file_exists($entryDir) && file_exists($entryFile)) {
            return $entryFile;
        }

        return false;
    }
}
