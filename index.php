<?php
/**
 * Front Controller
 * PHP version 7
 *
 * @category  Controller
 * @package   Front Controller
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   0.0.1
 * @link      http://dbrasil.tk/devbr
 */

//Loading application settings
include '.php/Config/App.php';

//Setup and mount Application
Config\App::this()->start();

//Route detection and controller call 
Devbr\Router::this()->run();

/*
  Optimize your application before putting it into production mode with the following command:
  "composer dump-autoload --optimize"
*/
