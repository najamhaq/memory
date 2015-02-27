<?php
/**
 * User: Najam.Haque
 * Date: 9/13/14
 * Time: 5:12 PM
 */
require_once('../../vendor/autoload.php');

/**
 * Sanitize the parameters .. these may eventually get to DB
 */
$row = intval($_POST['i']);
$col = intval($_POST['j']);

/**
 * We will just create a Grid of 0x0 for now
 * we dont know the dimension as we plan to load it from session
 */
try {
    $factory = new Memory\TextCardFactory();
    $grid = new Memory\Grid(0, 0, $factory);
    $grid->load();
    /**
     *  return a JSON to client
     */
    echo json_encode($grid->click($row, $col));
    $grid->save();
} catch (Exception $exception) {
    echo "Sorry, There is a problem. : ";
    echo $exception->getMessage();
}