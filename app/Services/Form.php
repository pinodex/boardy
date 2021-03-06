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

use Boardy\Services\Event\Event;
use Boardy\Services\Event\EventDispatcher;
use Symfony\Component\Form\Form as SymfonyForm;
use Symfony\Component\Form\FormError;

class Form extends Service
{
    /**
     * @var array Forms
     */
    private static $forms = array();

    /**
     * Create a new form builder
     *
     * @param string $identifier Form identifier
     *
     * @return Symfony\Component\Form\FormBuilder
     */
    public static function create($identifier, $data = null, array $options = array())
    {
        $form = self::$app->form($data, $options);
        self::$forms[$identifier] = $form;

        EventDispatcher::dispatch('form.' . $identifier . '.create', 
            new Event($form)
        );

        return $form;
    }

    public static function flashError($identifier, $message)
    {
        self::$app['flashbag']->add('form.' . $identifier . '.errors', $message);
    }

    public static function handleFlashErrors(SymfonyForm $form, $identifier)
    {
        $errors = self::$app['flashbag']->get('form.' . $identifier . '.errors');

        foreach ($errors as $error) {
            $form->addError(new FormError($error));
        }
    }

    /**
     * Get all form in collection
     *
     * @return array
     */
    public static function all()
    {
        return self::$forms;
    }

    /**
     * Get form from collection
     *
     * @param string $identifier Form identifier
     *
     * @return Symfony\Component\Form\FormBuilder
     */
    public static function getForm($identifier)
    {
        if (array_key_exists($identifier, self::$forms)) {
            return self::$forms[$identifier];
        }
    }
}
