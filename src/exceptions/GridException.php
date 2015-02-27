<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 11:15 PM
 */

namespace Memory;


/**
 * Class GridException
 * The Custom Excpetion Object thrown by Grid.
 * @package Memory
 */
class GridException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
} 