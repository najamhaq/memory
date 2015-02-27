<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 9/14/14
 * Time: 9:24 AM
 */

require_once('../../vendor/autoload.php');

/**
 * create a new grid and redirect to main page.
 */
$factory = new Memory\TextCardFactory();
$grid = new Memory\Grid(4, 6, $factory);
/**
 * remove it using Grids persistence ...
 */
$grid->remove();
header('Location: /', true, 302);
