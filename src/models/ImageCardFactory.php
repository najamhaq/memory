<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 9/14/14
 * Time: 12:10 AM
 */

namespace Memory;


/**
 * Class ImageCardFactory
 * @package Memory
 * @description Supplies a Method to create a stack of Cards. Used in Grid Class at the time of creation.
 */
class ImageCardFactory implements ICardFactory
{
    /**
     * call a specific implementation to creat a stack of cards, in this case ImageCard
     * @param $total
     * @return array
     */
    public function stack($total)
    {
        return ImageCard::stack($total);
    }

    /**
     * returns a session name used by Persistance classes to This separates different types of games in different sessions,
     * enabling mutiple type of play by the same user.
     * @return mixed
     */
    public function getSessionName()
    {
        return str_replace("\\", "_", get_class($this));
    }
}