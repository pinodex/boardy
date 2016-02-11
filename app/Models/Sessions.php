<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'sessions';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}