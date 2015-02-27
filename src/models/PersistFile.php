<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 9/14/14
 * Time: 2:10 AM
 */

namespace Memory;

/**
 * Class PersistFile
 * Uses File to save an object
 * @package Memory
 */
class PersistFile implements IPersistable
{
    private $name;
    const FILE_PATH = '/tmp';

    public function __construct($session_name)
    {
        $this->name = $session_name;
    }

    /**
     * returns Full name of the file where the object is stored
     * @param $key
     * @return string
     */
    public function getFullFileName($key)
    {
        return self::FILE_PATH . DIRECTORY_SEPARATOR . $this->name . '-' . $key . '.txt';
    }

    /**
     * load an object given its primary key
     * @param $key
     * @return mixed
     */
    public function load($key)
    {
        $data = "";
        if (file_exists($this->getFullFileName($key))) {
            $data = file_get_contents($this->getFullFileName($key));
        }
        return unserialize($data);
    }

    /**
     * saves an object using its primary key
     * @param $key
     * @param $data
     */
    public function save($key, $data)
    {
        file_put_contents($this->getFullFileName($key), serialize($data));
    }

    /**
     * removes an object using its primary key
     * @param $key
     */
    public function remove($key)
    {
        unlink($this->getFullFileName($key));
    }
}