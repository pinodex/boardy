<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services;

class Theme extends Service
{
    /**
     * Holds the array of codes that will be added in the
     * the head part of every template.
     *
     * @var array Associative array of codes
     */
    private static $head = array();

    /**
     * Holds the array of codes that will be added in the
     * the foot part of every template.
     *
     * @var array Associative array of codes
     */
    private static $foot = array();

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
     * @param string $template Template name
     * @param array $args Associative array of args to be passed to template
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

        return static::$app['twig']->render('@theme/' . $template . '.html', $args);
    }

}
