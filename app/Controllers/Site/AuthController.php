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
use Boardy\Constraints as CustomAssert;
use Boardy\Services\Session\Session;
use Boardy\Services\Form;
use Boardy\Services\Theme;
use Boardy\Services\Auth;
use Boardy\Services\Csrf;
use Boardy\Models\Users;

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

        $form = Form::create('login_form')
            ->add('username', Type\TextType::class, [
                'data' => Session::get('lastUsername'),
                'attr' => ['autofocus' => true]
            ])
            ->add('password', Type\PasswordType::class)
            ->add('remember', Type\CheckboxType::class, [
                'required'  => false,
                'label'     => 'Remember me'
            ]);

        $form = $form->getForm();
        $form->handleRequest($request);

        Form::handleFlashErrors($form, 'login_form');

        if ($form->isValid()) {
            $data = $form->getData();
            $user = Auth::attempt($data);

            Session::set('lastUsername', $data['username']);
            
            if (!$user) {
                Form::flashError('login_form', 'Invalid username and/or password');
                return $app->redirect($app->path('auth.login'));
            }

            if ($data['remember']) {
                // Change cookie lifetime to 1 month.
                Session::migrate(false, 60 * 60 * 24 * 30);
            }

            Auth::login($user);
            return $app->redirect($app->path('site.index'));
        }

        $vars['login_form'] = $form->createView();

        return Theme::view('auth/login', $vars);
    }

    public function logout(Request $request, Application $app)
    {
        if (Csrf::isValid('logout', $request->query->get('token'))) {
            Auth::logout();
        }

        return $app->redirect($app->path('site.index'));
    }

    public function register(Request $request, Application $app)
    {
        if (Auth::user()) {
            return $app->redirect($app->path('site.index'));
        }

        $vars = array(
            'page_title' => 'Register'
        );

        $form = Form::create('registration_form')
            ->add('name', Type\TextType::class)
            ->add('username', Type\TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern'   => '/^[A-Za-z0-9_]+$/',
                        'match'     => true,
                        'message'   => 'Username must only contain alphanumeric characters and underscores.'
                    ]),
                    new CustomAssert\UniqueRecord([
                        'model'     => Users::class,
                        'row'       => 'username',
                        'message'   => 'Username already in use.'
                    ])
                ]
            ])
            ->add('email', Type\TextType::class, [
                'constraints' => [
                    new Assert\Email(),
                    new CustomAssert\UniqueRecord([
                        'model'     => Users::class,
                        'row'       => 'email',
                        'message'   => 'Email already in use.'
                    ])
                ]
            ])
            ->add('password', Type\RepeatedType::class, [
                'type'              => Type\PasswordType::class,
                'first_options'     => ['label' => 'Password'],
                'second_options'    => ['label' => 'Repeat Password'],
                'invalid_message'   => 'Password fields did not match.',
                'constraints'       => [
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Password must be at least 8 characters.'
                    ])
                ]
            ]);

        $form = $form->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            
            $user = Users::create($data);
            Auth::login($user);
            
            return $app->redirect($app->path('site.index'));
        }

        $vars['registration_form'] = $form->createView();

        return Theme::view('auth/register', $vars);
    }
}
