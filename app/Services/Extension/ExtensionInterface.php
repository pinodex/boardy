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

interface ExtensionInterface
{
    /**
     * This method is invoked upon activation of extension
     *
     * @return boolean Return status of extension activation.
     *                 false value will not continue extension activation.
     */
    public function activate();

    /**
     * This method is invoked upon deactivation of extension
     *
     * @return boolean Return status of extension deactivation.
     *                 false value will not continue extension deactivation.
     */
    public function deactivate();

    /**
     * This method is invoked upon loading the extension.
     * Loading an extension happens every page load.
     * You can bootstrap your extension here, register events, etc.
     */
    public function load();
}
