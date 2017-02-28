<?php
/**
 * Resource\Main
 * PHP version 7
 *
 * @category  Controller
 * @package   FrontController
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   GIT: 0.0.1
 * @link      http://paulorocha.tk/devbr
 */

//App Configurations ...
include '.php/Config/App.php';

//Detect access data ...
// & call response controller 
Lib\Router::this()->run();
