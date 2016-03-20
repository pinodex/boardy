<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Boardy\Services\Assets\PublicAssets;
use Boardy\Services\Assets\Assets;

class AssetsServiceProvider implements ServiceProviderInterface
{
    /**
     * @var Boardy\Services\Themes\Asset Asset object
     */
    private $asset;

    /**
     * Register the Assets service
     *
     * @param Silex\Application $app
     */
    public function register(Application $app)
    {
        $fs = new Filesystem();

        $publicBase = $app['assets.options']['public_base'] . '/' . $app['theme.name'];
        $themePath = $app['assets.options']['public_path'] . '/' . $app['theme.name'];
        $assetsPath = $app['theme.path'] . '/assets';

        $this->asset = new Assets($assetsPath);

        if ($app['debug']) {
            $publicBase = $app['assets.options']['debug_base'];

            // Add our debug route to directly serve files
            // from the theme assets directory.
            $app->get($app['assets.options']['debug_base'] . '{path}', function ($path) {
                return $this->serveFile($path);
            })->assert('path', '.+');
        }
        else if (!$fs->exists($themePath)) {
            // Copy the theme assets directory to the public assets.
            $fs->mirror($assetsPath, $themePath, null, [
                'override'      => true,
                'copyonwindows' => true,
                'delete'        => true
            ]);
        }

        $app['assets'] = $app->share(function () use ($publicBase) {
            return new PublicAssets($publicBase);
        });
    }

    /**
     * Serve file from path
     *
     * @param string $path Path to file
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function serveFile($path)
    {
        $file = $this->asset->getFile($path);
        $contents = file_get_contents($file->getPathname());

        return Response::create($contents, 200, [
            'content-type' => $file->getMimeType()
        ]);
    }

    /**
     * Boot the Assets service
     *
     * @param Silex\Application $app
     */
    public function boot(Application $app)
    {
    }
}
