<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Themes;

class ThemeInfo
{
    private $theme;

    /**
     * Constructs ThemeInfo
     *
     * @param string $themeFilePath
     */
    public function __construct($themePath)
    {
        $this->theme = json_decode(file_get_contents($themePath . '/theme.json'));
    }

    /**
     * Get theme meta.
     *
     * return array
     */
    public function getMeta()
    {
        return $this->theme->meta;
    }

    /**
     * Get theme assets.
     *
     * return array
     */
    public function getAssets()
    {
        return $this->theme->assets;
    }
}
