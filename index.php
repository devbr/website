<?php
//App Configurations ...
include '.php/Config/App.php';

//Detect access data ...
// & call response controller 
(new Lib\Router)->run();
