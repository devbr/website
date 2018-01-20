<?php
/**
 * Front Controller
 * PHP version 7
 *
 * @category  Controller
 * @package   Front Controller
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2017 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   0.0.1
 * @link      https://github.com/devbr/
 */

//Setup and mount Application
include '.php/App.php';
App::this()->start();

//Route detection and controller call 
Devbr\Router::this()->run();

/*
  Optimize your application before putting it into production mode with the following command:
  "composer dump-autoload --optimize"
*/
