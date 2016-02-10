<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Themes;

use Silex\Application;

class Theme
{
    /**
     * Holds the application instance
     *
     * @var Silex\Application
     */
    private $app;

    /**
     * Holds the theme info object
     *
     * @var Boardy\Services\Themes\ThemeInfo
     */
    private static $themeInfo;

    /**
     * Holds the array of codes that will be added in the
     * the head part of every template
     *
     * @var array
     */
    private static $head = array();

    /**
     * Holds the array of codes that will be added in the
     * the foot part of every template
     *
     * @var array
     */
    private static $foot = array();


    /**
     * Holds the Theme instance statically
     *
     * @var Boardy\Services\Themes\Theme
     */
    private static $this;

    /**
     * Constructs the Theme class
     *
     * @param Silex\Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
        
        static::$themeInfo = new ThemeInfo($app['theme.path']);
        static::$this = $this;
    }

    /**
     * Get theme info
     *
     * @return Boardy\Services\Themes\ThemeInfo
     */
    public static function getThemeInfo()
    {
        return static::$this->themeInfo;
    }

    /**
     * Add code to head
     *
     * @param string $code
     */
    public static function addToHead($code)
    {
        static::$head[] = $code;
    }

    /**
     * Add code to foot
     *
     * @param string $code
     */
    public static function addToFoot($code)
    {
        static::$foot[] = $code;
    }

    /**
     * Get view by template name
     *
     * @param string $template
     * @param array $args
     *
     * @return string
     */
    public static function view($template, $args = array())
    {
        if (!isset($args['head'])) {
            $args['head'] = array();
        }

        if (!isset($args['foot'])) {
            $args['foot'] = array();
        }

        $args['head'] = array_merge(static::$head, $args['head']);
        $args['foot'] = array_merge(static::$foot, $args['foot']);

        return static::$this->app['twig']->render('@theme/' . $template . '.html', $args);
    }

}