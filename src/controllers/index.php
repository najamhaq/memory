<?php
require_once('../../vendor/autoload.php');
try {
    /**
     * Though we are using TextCard, as an example other variations
     * mayuse an ImageCard as shown below
     * $factory = new Memory\ImageCardFactory();
     */

    $factory = new Memory\TextCardFactory();
    $grid = new Memory\Grid(4, 6, $factory);
    /**
     * randomly setup card or load from session
     */
    $grid->initialize();
    /**
     * randomly setup card or load from session
     */
    $grid->save();
} catch (Exception $exception) {
    echo "Sorry, There is a problem. : ";
    echo $exception->getMessage();
}

require_once('../views/index.php');