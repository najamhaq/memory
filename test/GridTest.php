<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 1:28 PM
 */


class GridTest extends PHPUnit_Framework_TestCase
{

    public function testImageCardCreation()
    {
        $factory = new Memory\ImageCardFactory();
        $grid = new Memory\Grid(2,4,$factory);
        $this->assertTrue(is_object($grid));
    }

    public function testTextCardCreation()
    {
        $factory = new Memory\TextCardFactory();
        $grid = new Memory\Grid(4,6,$factory);
        $this->assertTrue(is_object($grid));
    }

    public function testCreationWithFilePersistance()
    {
        $factory = new Memory\TextCardFactory();
        $persist = new Memory\PersistFile('MemoryFile');
        $grid = new Memory\Grid(4,6,$factory, $persist);
        $this->assertTrue(is_object($grid));
    }

    public function testPersistance()
    {
        $factory = new Memory\TextCardFactory();
        $persist = new Memory\PersistFile('MemoryFile');
        $grid = new Memory\Grid(4,6,$factory, $persist);
        $grid->save('my-session-id');
        $this->assertTrue(file_exists($persist->getFullFileName('my-session-id')));
    }

    public function testInitialze()
    {
        $factory = new Memory\TextCardFactory();
        $persist = new Memory\PersistFile('MemoryFile');
        $grid = new Memory\Grid(4,6,$factory, $persist);
        $grid->initialize('my-session-id');
        // grid should now 4x6 cards
        $grid->save('my-session-id'); // not the best way to test
        $this->assertTrue(file_exists($persist->getFullFileName('my-session-id')));
    }

    public function testClick()
    {
        $factory = new Memory\TextCardFactory();
        $persist = new Memory\PersistFile('MemoryFile');
        $grid = new Memory\Grid(2,2,$factory, $persist);
        $grid->initialize('my-session-id');
        $grid->click(0,0);
        $grid->click(0,1);
        $grid->save('my-session-id'); // not the best way to test
        $this->assertTrue(file_exists($persist->getFullFileName('my-session-id')));
    }


} 