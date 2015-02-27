<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 11:55 PM
 */

namespace Memory;

/**
 * Interface CardFactory
 * This interface must be supported by Any Card Factory. Card Factories are used to create Cards of different types.
 * @package Memory
 */
interface ICardFactory
{
    public function stack($total);

    public function getSessionName();
} 