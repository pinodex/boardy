<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Auth;

use Boardy\Services\Service;
use Boardy\Services\Session\Session;
use Boardy\Services\Hash\Hash;
use Boardy\Models\Users;
use Silex\Application;

class Auth extends Service
{
    /**
     * @var Boardy\Models\Users Current logged in user. Used to cache user model for single request.
     */
    private static $user;

    /**
     * Authenticate user by username and password
     *
     * @param string|array $data Username or array of username and password
     * @param string $password Password
     *
     * @return Boardy\Models\Users
     */
    public static function attempt($data, $password = null)
    {
        if (is_array($data)) {
            $password = $data['password'];
            $data = $data['username'];
        }

        if ($user = Users::where('username', $data)->orWhere('email', $data)->first()) {
            if (Hash::check($password, $user->password)) {
                $user->last_login_at = currentDate();
                $user->save();

                return $user;
            }
        }
    }

    /**
     * Get logged in user
     *
     * @return Boardy\Models\Users
     */
    public static function user()
    {
        if (self::$user) {
            return self::$user;
        }

        if ($userId = Session::get('userId')) {
            if ($user = Users::find($userId)) {
                $user->touch();

                self::$user = $user;
                return $user;
            }
        }
    }

    /**
     * Is user logged in or guest?
     *
     * @return boolean
     */
    public static function guest()
    {
        return self::user() == null;
    }

    /**
     * Remove session and logout user
     */
    public static function logout()
    {
        Session::remove('userId');
    }
}
