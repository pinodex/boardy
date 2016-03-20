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

use Boardy\Services\Service;
use Boardy\Models\Configurations;

class Config extends Service
{
    /**
     * @var array Associative array of config values
     */
    private static $config = array();

    /**
     * Load config values from database
     */
    public static function load()
    {
        $entries = Configurations::get();
        
        foreach ($entries as $entry) {
            self::$config[$entry->id] = unserialize($entry->value);
        }
    }

    /**
     * Get entry by id
     *
     * @param string $id Entry id
     * @param mixed $default Default value when config entry does not exist
     *
     * @return mixed
     */
    public static function get($id, $default = null)
    {
        if (array_key_exists($id, self::$config)) {
            return self::$config[$id];
        }

        return $default;
    }

    /**
     * Set entry by id
     *
     * @param string $id Entry id
     * @param mixed $value Entry value
     */
    public static function set($id, $value)
    {
        self::$config[$id] = $value;

        if (Configurations::where('id', $id)->exists()) {
            Configurations::where('id', $id)->update([
                'value' => serialize($value)
            ]);

            return;
        }

        Configurations::insert([
            'id' => $id,
            'value' => serialize($value)
        ]);
    }

    /**
     * Remove entry
     *
     * @param string $id Entry id
     */
    public static function remove($id)
    {
        if ($value = Configurations::find($id)) {
            $value->delete();
            unset(self::$config[$id]);
        }
    }

}
