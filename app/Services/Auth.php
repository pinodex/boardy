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

use Boardy\Services\Event\EventDispatcher;
use Boardy\Services\Session\Session;
use Boardy\Services\Event\Event;
use Boardy\Services\Hash;
use Boardy\Models\User;

class Auth extends Service
{
    /**
     * @var Boardy\Models\User Current logged in user. Used to cache user model for single request.
     */
    private static $user;

    /**
     * Authenticate user by username and password
     *
     * @param string|array $data Username or array of username and password
     * @param string $password Password
     *
     * @return Boardy\Models\User
     */
    public static function attempt($data, $password = null)
    {
        EventDispatcher::dispatch('auth.attempt', new Event(func_get_args()));

        if (is_array($data)) {
            $password = $data['password'];
            $data = $data['username'];
        }

        if ($user = User::where('username', $data)->orWhere('email', $data)->first()) {
            if (!Hash::check($password, $user->password)) {
                EventDispatcher::dispatch('auth.fail', null);
                return;
            }

            if (Hash::needsRehash($user->password)) {
                $user->password = $password;
                $user->save();

                EventDispatcher::dispatch('auth.rehash', $user);
            }

            return $user;
        }
    }

    /**
     * Get logged in user
     *
     * @return Boardy\Models\User
     */
    public static function user()
    {
        if (self::$user) {
            return self::$user;
        }

        if ($userId = Session::get('userId')) {
            if ($user = User::find($userId)) {
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
        return self::$user === null;
    }

    /**
     * Login user
     *
     * @param Boardy\Models\User $user User model
     */
    public static function login($user)
    {
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->save();

        Session::set('userId', $user->id);
        EventDispatcher::dispatch('auth.login', new Event($user));
    }

    /**
     * Remove session and logout user
     */
    public static function logout()
    {
        Session::remove('userId');
        EventDispatcher::dispatch('auth.logout', self::$user);
    }
}
