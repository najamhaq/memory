<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 2:13 PM
 */

namespace Memory;


/**
 * Class TextCard
 * @package Memory
 */
class TextCard extends Card
{
    /**
     * @param $name
     */
    public function __construct($name)
    {
        parent::__construct('Text Card ' . $name);
    }


    /**
     * creates a stack of cards.
     * @param $total
     * @return array
     */
    public static function stack($total)
    {
        $cards = array();
        for ($i = 0; $i < $total; $i++) {
            $card[] = new TextCard($i);
        }
        return $card;
    }


    /**
     * renders the actual card. This is type specfici implementation. Different Cards may render differntly.
     * @param bool $force
     * @return string
     */
    public function render($force = false)
    {
        if ($force || $this->flipped) {
            return parent::getName();
        } else {
            return "Face Down ";
        }
    }
} 