<?php
/**
 * Config\App
 * PHP version 7
 *
 * @category  Config
 * @package   App
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   GIT: 0.0.2
 * @link      http://paulorocha.tk/devbr
 */

// Defaults
error_reporting(E_ALL ^ E_STRICT ^ E_WARNING);
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

// Development only...
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('track_errors', '1');

// Path to WWW
$base = dirname(dirname(__DIR__));
defined('_WWW')    || define('_WWW', str_replace('\\', '/', strpos($base, 'phar://') !== false
                            ? dirname(str_replace('phar://', '', $base)).'/'
                            : $base.'/'));
// Path if PHAR mode or false
defined('_PHAR')   || define('_PHAR', strpos(_WWW, 'phar://') !== false ? _WWW : false);
defined('_APP')    || define('_APP', dirname(__DIR__).'/');   //Path to Application
defined('_CONFIG') || define('_CONFIG', __DIR__.'/');         //Path to config files
defined('_HTML')   || define('_HTML', _APP.'Html/');          //Path to HTML files

// Composer autoloader
if (file_exists(_APP.'Composer/autoload.php')) {
    include _APP.'Composer/autoload.php';
}

//Onm Cli mode
if (php_sapi_name() === 'cli') {
    return new Lib\Cli\Main($argv);
}
