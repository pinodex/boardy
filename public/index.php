<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);

require_once ROOT . 'vendor/autoload.php';

$app = require APP . 'bootstrap.php';
$app->run();
