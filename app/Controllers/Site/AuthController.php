<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Controllers\Site;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Boardy\Services\Theme;
use Boardy\Services\Auth;

class AuthController
{
    public function login(Request $request, Application $app)
    {
        if (Auth::user()) {
            return $app->redirect($app->path('site.index'));
        }

        $vars = array(
            'page_title' => 'Login'
        );

        $loginForm = $app->form()
            ->add('username', Type\TextType::class)
            ->add('password', Type\PasswordType::class)
            ->add('remember', Type\CheckboxType::class, [
                'required' => false,
                'label' => 'Remember me'
            ]);

        $loginForm = $loginForm->getForm();
        $loginForm->handleRequest($request);

        handleFormErrors($loginForm, $app['flashbag']->get('formErrors'));

        if ($loginForm->isValid()) {
            $data = $loginForm->getData();
            $user = Auth::attempt($data);
            
            if (!$user) {
                $app['flashbag']->add('formErrors', 'Invalid username and/or password');
                return $app->redirect($app->path('auth.login'));
            }

            if ($data['remember']) {
                // Change cookie lifetime to 1 month.
                $app['session']->migrate(false, 60 * 60 * 24 * 30);
            }

            $app['session']->set('userId', $user->id);
            return $app->redirect($app->path('site.index'));
        }

        $vars['login_form'] = $loginForm->createView();

        return Theme::view('auth/login', $vars);
    }

    public function logout(Request $request, Application $app)
    {
        if (isCsrfTokenValid($app, 'logout', $request->query->get('token'))) {
            Auth::logout();
        }

        return $app->redirect($app->path('site.index'));
    }
}
