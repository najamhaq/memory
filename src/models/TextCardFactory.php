<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 11:54 PM
 */

namespace Memory;

/**
 * Class TextCardFactory
 * Supplies a Method to create a stack of Cards. Used in Grid Class at the time of creation.
 * @package Memory
 */
class TextCardFactory implements ICardFactory
{
    /**
     * call a specific implementation to creat a stack of cards, in this case TextCard
     * @param $total
     * @return array
     */
    public function stack($total)
    {
        return TextCard::stack($total);
    }

    /**
     * returns a session name used by Persistance classes to This separates different types of games in different sessions,
     * enabling mutiple type of play by the same user.
     * @return mixed
     */
    public function getSessionName()
    {
        return str_replace("\\","_",get_class($this));
    }
} 