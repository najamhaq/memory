<?php
/**
 * User: Najam.Haque
 * Date: 9/14/14
 * Time: 1:16 AM
 */

namespace Memory;


/**
 * All Persistance is supported through this interface . This not really a good name .... but in a hurry I cant think better :(
 * Interface Persistable
 * @package Memory
 */
interface IPersistable
{
    /**
     * load an object given its primary key
     * @param $key
     * @return array
     */
    public function load($key);

    /**
     * saves an object using its primary key
     * @param $key
     * @param $value
     * @return nothing
     */
    public function save($key, $value);

    /**
     * removes an object using its primary key
     * @param $key
     * @return nothing
     */
    public function remove($key);
} 