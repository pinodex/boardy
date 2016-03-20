<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Form;
use Boardy\Services\Csrf;

/**
 * Get installed Boardy version
 *
 * @return string
 */
function getBoardyVersion()
{
    return Boardy::VERSION;
}

/**
 * Returns current date, useful for database storage
 *
 * @return string
 */
function currentDate()
{
    return date('Y-m-d H:i:s');
}

/**
 * Add form error from flashbag
 *
 * @param Form $form Form
 * @param array $errors Array of string of errors
 */
function handleFormErrors(Form $form, $errors)
{
    foreach ($errors as $error) {
        $form->addError(new FormError($error));
    }
}

/**
 * Shortcut to Boardy\Services\Csrf::isValid. Checks if token is valid for the identifier.
 *
 * @param string $identifier Token identifier
 * @param string $token Token string
 *
 * @return boolean
 */
function isCsrfTokenValid($identifier, $token)
{
    return Csrf::isValid($identifier, $token);
}
