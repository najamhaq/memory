<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 12:44 PM
 */

namespace Memory;

/**
 * Class Grid
 * @package Memory
 */
class Grid
{
    protected $factory;  // used to creat card stacks
    protected $persist;  // used to creat card stacks

    protected $height;
    protected $width;
    protected $cards;    // array of cards

    protected $secondClick;  // flag to represent whether we are in first click or second click of a turn
    // TODO ::: This is a limitation of our system ... if we later want to extend this to a three click system ... we cant do using this approach
    // This can be avoided using an array of opened cards in current turn .. however I decided not to go to that extent for now.


    // we need the cord as well of card flipped in first click.
    protected $visibleX;  // co-ordinate the card that is currently open
    protected $visibleY;  // co-ordinate the card that is currently open


    /**
     * Constructor to creat a Grid Object. This will not setup the entire grid that may be loaded later
     * @param $_height
     * @param $_width
     * @param ICardFactory $factory
     * @param IPersistable $persist
     */
    public function __construct($_height, $_width, ICardFactory $_factory, IPersistable $_persist = null)
    {
        $this->factory = $_factory; // is not stored as part of save / load
        $this->height = $_height;
        $this->width = $_width;
        $this->cards = null;
        $this->secondClick = false;
        $this->visibleX = null;
        $this->visibleY = null;
        if (is_null($_persist)) {
            /**
             * Persist the Grid via Session, in case caller has not provided
             */
            $this->persist = new PersistSession($_factory->getSessionName());
            /**
             * Developers may create new impmentation of persisnatce .e.g
             * $this->persist = new PersistMemCache();  // Persist the Grid via MemCache
             * $this->persist = new PersistRDBS();  // Persist the Grid via DB e.g MySQL
             * $this->persist = new PersistFile();  // Persist the Grid via File
             */
        } else {
            $this->persist = $_persist;
        }
    }


    /**
     * Initialize a grid either by loading from Persistance Object , or initialize cards from scracth using CardFactory
     * @param null $id
     * @throws GridException
     */
    public function initialize($id = null)
    {
        $this->load($id); // try to load from sesion

        if (is_array($this->cards) && $this->height > 0 && $this->width > 0) {
            //     Grid Loaded from Session
            return;
        }
        //  New Grid Created


        $totalUniqueCards = $this->height * $this->width / 2;
        if ($this->height * $this->width % 2) {
            throw new GridException("Invalid grid size.");
        }
        $uniqueCards = $this->factory->stack($totalUniqueCards); // get a stack of cards
        $uniqueCards2 = $this->factory->stack($totalUniqueCards);// get another stack of cards
        $duplicatedCards = array_merge($uniqueCards, $uniqueCards2);
        shuffle($duplicatedCards);
        $this->cards = array();
        for ($row = 0; $row < $this->height; $row++) {
            for ($col = 0; $col < $this->width; $col++) {
                $this->cards[$row][$col] = array_pop($duplicatedCards);
                /**
                 * latter a generator will be used to  infuse different card types
                 */
            }
        }
    }


    /**
     * load the grid using from Persistance Object (supplied at the time of creation)
     * @param null $id : defaulted to session id , but could be any other number used as a primary key
     */
    public function load($id = null)
    {
        if (is_null($id)) {
            $id = session_id();
        }


        $data = $this->persist->load(session_id());
        if (isset($data['height']) && $data['height'] > 0) {
            $this->height = $data['height'];
        }
        if (isset($data['width']) && $data['width'] > 0) {
            $this->width = $data['width'];
        }


        if (isset($data['second_click'])) {
            $this->secondClick = $data['second_click'];
        }

        if (isset($data['visible_x'])) {
            $this->visibleX = $data['visible_x'];
        }

        if (isset($data['visible_y'])) {
            $this->visibleY = $data['visible_y'];
        }


        if (isset($data['cards'])) {
            $_cards = unserialize($data['cards']);
            /**
             * @TODO better check as this still could fail ..  width is not cheked
             */
            if (is_array($_cards) && count($_cards) == $this->height) {
                $this->cards = $_cards;
            }
        }
    }

    /**
     * removes the grid using Persistance Object (supplied at the time of creation)
     * @param null $id
     */
    public function remove($id = null)
    {
        if (is_null($id)) {
            $id = session_id();
        }
        $this->persist->remove($id);
    }

    /**
     * save grid to persisantce object (supplied at the time of creation)
     * @param null $id : defaulted to session id , but could be any other number used as a primary key
     */
    public function save($id = null)
    {
        if (is_null($id)) {
            $id = session_id();
        }


        $data = array(
            'height' => $this->height,
            'width' => $this->width,
            'visible_x' => $this->visibleX,
            'visible_y' => $this->visibleY,
            'visible_y' => $this->visibleY,
            'second_click' => $this->secondClick,
            'cards' => serialize($this->cards),
        );
        $this->persist->save($id, $data);
    }

    /**
     * render the grid . This code currently uses html. It is recommended to take HTML out of this class altogather and an implemnetation should be html independent
     * @throws GridException
     */
    function render()
    {
        if (!is_array($this->cards)) {
            throw new GridException("Grid Not Setup."); // throw an exception
        }
        $gridRenderer = new GridRenderer();
        $gridRenderer->render($this);
    }


    public function getCard($row, $col)
    {
        $this->boundsCheck();

        return $this->cards[$row][$col];
    }

    /**
     * Actual click on the grid . Main functionlity of the game logic built here.
     * @param $row
     * @param $col
     * @return array
     * @throws GridException
     */
    public function click($row, $col)
    {
        $this->boundsCheck($row, $col);


        if ($this->cards[$row][$col]->isFlipped()) {
            throw new GridException("Card is alredy flipped");
        }

        ///////////////////////////////////////////////////////////////////////
        // After all the sanity check,  perform the actual operation
        // which could still fail , e.g flip method not defined on that object
        ///////////////////////////////////////////////////////////////////////

        /////////////////////////////////
        // initialize variables to default
        /////////////////////////////////
        $card_Rendered = "";
        $firstRender = "";
        $matched = 'first'; // matched is an enum {'first', 'true' , 'false'}

        /////////////////////////////////
        // save what is currently visible
        // we may need to reset that
        // but still need old values
        ////////////////////////////////
        $visibleY = $this->visibleY;
        $visibleX = $this->visibleX;


        if ($this->secondClick) {
            /**
             * This is the second card in a two click turn
             * Since this is the second card of the current turn, the card will have its temporary status removed
             * meaning that if it is visible .. it will remain visible.
             * if its fliped down . it will remain fliped down untill next turn
             */
            $this->secondClick = false;
            $this->visibleX = null;
            $this->visibleY = null;

            /**
             * assume that the card match .. [we set to false if names dont match]
             */

            $matched = 'true';
            /**
             * if card dont names match  .. keep both close
             */
            if ($this->cards[$visibleX][$visibleY]->getName() != $this->cards[$row][$col]->getName()) {
                /**
                 * flip it back to what it was as names dont match
                 */
                $this->cards[$visibleX][$visibleY]->flipDown(); // put it face down again
                $firstRender = $this->cards[$visibleX][$visibleY]->render(); // we will need this on client side
                $matched = 'false';
            } else {
                /**
                 * put it face up .. it macthed
                 */
                $this->cards[$row][$col]->flipUp();
            }

            /**
             * somehow the above only flips the visible memeber .. and not the grid item ..
             */
            $card_Rendered = $this->cards[$row][$col]->render(true);
        } else {
            /**
             * mark it the first card in a two click turn
             */
            $this->secondClick = true;

            /**
             * somehow marking the above with ref does not work we need the co-ordinates
             */
            $this->visibleX = $row;
            $this->visibleY = $col;

            $this->cards[$this->visibleX][$this->visibleY]->flipUp(); // make it visible
            $card_Rendered = $this->cards[$this->visibleX][$this->visibleY]->render();  // and now render
        }

        return array(
            'row' => $row, 'col' => $col,         // this is required on client to find which element to display
            'visible_x' => $visibleX, 'visible_y' => $visibleY, // this is required on client to find which element to turn off in  case its a miss
            'render' => $card_Rendered,
            'first_render' => $firstRender,
            'match' => $matched
        );
    }

    /**
     * Check if given array indices are within limits
     * @param $row
     * @param $col
     * @throws GridException
     */
    private function boundsCheck($row, $col)
    {
        if ($row > $this->height) {
            throw new GridException('Out of row bound');
        }

        if ($col > $this->width) {
            throw new GridException('Out of col bound');
        }

        if (!isset($this->cards[$row][$col])) {
            throw new GridException('Perhaps Grid not initialized.');
        }

        if (!is_object($this->cards[$row][$col])) {
            throw new GridException('Perhaps Grid not initialized.');
        }
    }


} 