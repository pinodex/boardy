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

use Boardy\Services\Event\EventDispatcher;
use Boardy\Services\Form;
use Boardy\Services\Theme;

class Extension implements ExtensionInterface
{
    /**
     * @var string Extension name
     */
    protected $name;

    /**
     * @var string Extension author
     */
    protected $author;

    /**
     * @var string Extension version
     */
    protected $version;

    /**
     * @var string Extension required Boardy version
     */
    protected $boardyVersion;

    /**
     * {@inheritDoc}
     */
    public function activate()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function deactivate()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function load()
    {
        return;
    }

    /**
     * Get extension name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get extension author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get extension version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get required Boardy version
     *
     * @return string
     */
    public function getBoardyVersion()
    {
        return $this->boardyVersion;
    }

    /**
     * Wrapper for EventDispatcher->addListener()
     * Add event listener to event dispatcher
     *
     * @param string $eventName The event to listen on
     * @param callable $listener The listener
     */
    public function addEventListener($eventName, callable $listener)
    {
        EventDispatcher::addListener($eventName, $listener);
    }

    /**
     * Wrapper for Form::getForm()
     * Get form from collection
     *
     * @param string $identifier Form identifier
     *
     * @return Symfony\Component\Form\FormBuilder
     */
    public function getForm($identifier)
    {
        return Form::getForm($identifier);
    }

    /**
     * Wrapper for Theme::addToHead()
     * Add code to <head /> of template
     *
     * @param string $code Code
     */
    public function addToHead($code)
    {
        return Theme::addToHead($code);
    }

    /**
     * Wrapper for Theme::addToFoot()
     * Add code before </body> of template
     *
     * @param string $code Code
     */
    public function addToFoot($code)
    {
        return Theme::addToFoot($code);
    }
}
