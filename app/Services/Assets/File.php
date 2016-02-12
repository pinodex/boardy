<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Assets;

use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class File extends SymfonyFile
{
    /**
     * @var array Mime type list by file extension
     */
    private static $mimes = [
        'swf'   => 'application/x-shockwave-flash',
        'xhtml' => 'application/xhtml+xml',
        'xht'   => 'application/xhtml+xml',
        'js'    => 'text/javascript',
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'jpe'   => 'image/jpeg',
        'png'   => 'image/png',
        'tiff'  => 'image/tiff',
        'tif'   => 'image/tiff',
        'css'   => 'text/css',
        'html'  => 'text/html',
        'htm'   => 'text/html',
        'shtml' => 'text/html',
        'txt'   => 'text/plain',
        'text'  => 'text/plain',
        'rtx'   => 'text/richtext',
        'rtf'   => 'text/rtf',
        'xml'   => 'text/xml',
        'xsl'   => 'text/xml',
        'json'  => 'text/json'
    ];

    /**
     * @var string Default mime type to be returned in case no match is found in the list
     */
    private static $defaultMime = 'application/octet-stream';

    /**
     * Get mime type by file extension from mime types list
     *
     * @return string
     */
    public function getMimeType()
    {
        $ext = $this->getExtension();

        if (isset(static::$mimes[$ext])) {
            return static::$mimes[$ext];
        }

        return static::$defaultMime;
    }
}