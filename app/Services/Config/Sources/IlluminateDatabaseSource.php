<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services\Config\Sources;

use Illuminate\Database\Capsule\Manager as Capsule;

class IlluminateDatabaseSource implements SourceInterface
{
    /**
     * @var Illuminate\Database\Capsule\Manager Database capsule instance
     */
    private $capsule;

    /**
     * @var string Database table to use for configs
     */
    private $table;

    /**
     * @var array Associative array of configs
     */
    private $config = array();

    /**
     * Constructs IlluminateDatabase
     *
     * @param Illuminate\Database\Capsule\Manager $capsule Database capsule instance
     * @param string Database table to use for configs
     */
    public function __construct(Capsule $capsule, $table)
    {
        $this->capsule = $capsule;
        $this->table = $table;
    }

    /**
     * Get new instance of query builder
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function table()
    {
        return $this->capsule->table($this->table);
    }

    /**
     * {@inheritdoc}
     */
    public function open()
    {
        $entries = $this->table()->get();
        
        foreach ($entries as $entry) {
            $this->config[$entry->key] = unserialize($entry->value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;

        if ($this->table()->where('key', $key)->exists()) {
            $this->table()->where('key', $key)->update([
                'value' => serialize($value)
            ]);

            return;
        }

        $this->table()->insert([
            'key' => $key,
            'value' => serialize($value)
        ]);
    }
}
