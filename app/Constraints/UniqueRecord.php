<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueRecord extends Constraint
{
    /**
     * @var string Model class for record check
     */
    public $model;

    /**
     * @var string Row to check
     */
    public $row;

    /**
     * @var string Comparison operator to use in where clause
     */

    public $comparator = '=';

    /**
     * @var string Value to exlude in check
     */
    public $exclude;

    /**
     * @var string Error message
     */
    public $message = 'Record already exists.';
}
