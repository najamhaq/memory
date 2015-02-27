<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 2:13 PM
 */

namespace Memory;


/**
 * Class ImageCard
 * @package Memory
 */
class ImageCard extends Card
{

    public function __construct($name)
    {
        parent::__construct('Image Card ' . $name);
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
            $card[] = new ImageCard($i);
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