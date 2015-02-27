<?php
/**
 * User: Najam.Haque
 * Date: 9/14/14
 * Time: 1:12 AM
 */

namespace Memory;

/**
 * saves an object using its primary key
 * Class PersistSession
 * @package Memory
 */
class PersistSession implements IPersistable
{
    private $name ;

    public function __construct($session_name)
    {
        $this->name = $session_name;
    }


    /**
     * load an object given its primary key
     * @param $key
     * @return mixed
     */
    public function load($key)
    {
        session_name($this->name);
        session_start();
        return isset($_SESSION['data']) ? $_SESSION['data'] : null ;
    }

    /**
     * saves an object using its primary key
     * @param $key
     * @param $data
     */
    public function save($key, $data)
    {
        session_name($this->name);
        // generally session would already be started by a load statement earlier
        $_SESSION['data'] =$data;
    }

    /**
     * removes an object using its primary key
     * @param $key
     */
    public function remove($key)
    {
        session_name($this->name);
        session_start();
        $_SESSION['data'] = '';
    }
}