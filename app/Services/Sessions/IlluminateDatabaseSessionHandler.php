<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphael.marco@hotmail.ph>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Sessions;

use Illuminate\Database\Capsule\Manager as Capsule;

class IlluminateDatabaseSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var array Database session storage options
     */
    private $options;

    /**
     * @var bool Whether gc() has been called
     */
    private $gced = false;

    /**
     * Constructs the class
     *
     * @param array $app
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Get new instance of query builder
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function table()
    {
        return Capsule::table($this->options['table']);
    }

    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if ($this->gced) {
            $this->table()->where('expiry', '<', time())->delete();
            $this->gced = false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        if ($session = $this->table()->find($id)) {
            return $session->data;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write($id, $data)
    {
        $lifetime = (int) ini_get('session.gc_maxlifetime');
        $values = array(
            'id'        => $id,
            'data'      => $data,
            'expiry'    => $lifetime + time()
        );
        
        if ($this->table()->find($id)) {
            $this->table()->where('id', $id)->update($values);

            return true;
        }

        $this->table()->insert($values);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxLifeTime)
    {
        $this->gced = true;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        $this->table->where('id', $id)->delete();

        return true;
    }
}
