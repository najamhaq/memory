<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 2:10 PM
 */

namespace Memory;

/**
 * Class Card
 * @package Memory
 */
abstract class Card
{

    /**
     * represents whethe a card is faced up or down  ..accessible to derived classes .. e.g TextCard , ImageCard
     * @var bool
     */
    protected $flipped;

    /**
     * represents the name of card .. Thenames are used to check equality, in order to make a match.
     * @var string
     */
    protected $name;

    public function __construct($name)
    {
        $this->flipped = false; // a card is created face down
        $this->name = $name;
    }

    /**
     * @return mixed
     * @description returns the name of the card.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @description puts the card face up
     */
    public function flipUp()
    {
        $this->flipped = true;
    }

    /**
     * @description puts the card face down
     */
    public function flipDown()
    {
        $this->flipped = false;
    }

    /**
     * tells if the card is FaceUp or not
     * @return bool
     */
    public function isFlipped()
    {
        return $this->flipped;
    }

    /*******************************************************
     * Following methods must be supplied by Any Type of Card
     ********************************************************/

    /**
     * creates a stack of cards
     * @param $total
     * @return array of cards
     */
    abstract public static function stack($total); // used by CardFactory


    /**
     * renders the card. A Card Type need to supply its render mechanism.
     * @param $force
     * @return nothing
     */
    abstract public function render($force);    // used by Grids
}