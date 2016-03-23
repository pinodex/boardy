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

class Hash
{
    /**
     * Creates a password hash
     *
     * @param string $password Source password
     *
     * @return string
     */
    public static function make($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verifies that the given hash matches the given password
     *
     * @param string $password Source password
     * @param string $hash Hashed password
     *
     * @return boolean
     */
    public static function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Check if password needs rehash
     *
     * @param strig $hash Hashed password
     *
     * @return boolean
     */
    public static function needsRehash($hash)
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT);
    }
}
