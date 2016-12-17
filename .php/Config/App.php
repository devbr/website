<?php
/**
 * PHP Base
 * @copyright   Bill Rocha - http://google.com/+BillRocha
 * @license     MIT
 * @author      Bill Rocha - prbr@ymail.com
 * @version     0.0.1
 * @package     Config
 * @access      public
 * @since       0.3.0
 *
 * The MIT License
 *
 * Copyright 2015 http://google.com/+BillRocha.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

// Defaults
error_reporting(E_ALL ^ E_STRICT ^ E_WARNING);
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo'); 

// development only...
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('track_errors', '1');

// Path to WWW
$base = dirname(dirname(__DIR__));
defined('_WWW')    || define('_WWW', str_replace('\\', '/', strpos($base, 'phar://') !== false
                    		? dirname(str_replace('phar://', '',$base)).'/'
                    		: $base.'/'));
// Path if PHAR mode or false
defined('_PHAR')   || define('_PHAR', strpos(_WWW, 'phar://') !== false ? _WWW : false);
defined('_APP')    || define('_APP', dirname(__DIR__).'/');	//Path to Application
defined('_CONFIG') || define('_CONFIG', __DIR__.'/');		//Path to config files
defined('_HTML')   || define('_HTML', _WWW.'html/');		//Path to HTML files

// Autoload
set_include_path(_APP.PATH_SEPARATOR.get_include_path());
spl_autoload_register(function($class) {
    $file = _APP.str_replace('\\', '/', trim($class, '\\')).'.php';
    if(file_exists($file) !== false) require_once $file;
    return class_exists($class, false);
});

// Composer autoloader
if(file_exists(_APP.'Composer/autoload.php')) include _APP.'Composer/autoload.php';

// Error/Exception
set_error_handler(['Lib\Debug','errorHandler']);
set_exception_handler(['Lib\Debug', 'exceptionHandler']);

//Onm Cli mode
if(php_sapi_name() === 'cli') return new Core($argv);
