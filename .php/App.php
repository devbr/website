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
 * @link      http://dbrasil.tk/devbr
 */
namespace Config;

return new App;

class App
{

    private static $node =      null;

    private static $php =    false;
    private static $config = false;
    private static $web =    false;
    private static $html =   false;

    private static $mode =      0;
    private static $isPhar =    false;

    private static $psr4 =      [];

    
    function _construct()
    {
        //Set defaults
        $this->setDefaults();

        if (!is_object(static::$node)) {
            static::$node = $this;
        }
    }
    /**
     * Singleton instance
     *
     */
    static function this()
    {
        if (is_object(static::$node)) {
            return static::$node;
        }
        //else...
        return static::$node = new static;
    }

    function setDefaults()
    {
        // Defaults
        error_reporting(E_ALL ^ E_STRICT ^ E_WARNING);
        setlocale (LC_ALL, 'pt_BR');
        date_default_timezone_set('America/Sao_Paulo');

        // Development only...
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        ini_set('track_errors', '1');
    }

    function start()
    {
        // Web
        if (static::$web === false) {
            $base = dirname(dirname(__DIR__));
            static::$web = str_replace('\\', '/', strpos($base, 'phar://') !== false
                            ? dirname(str_replace('phar://', '', $base)).'/'
                            : $base.'/');
        }

        // Is Phar?
        if (static::$isPhar === false) {
            static::$isPhar = strpos(static::$web, 'phar://') !== false ? static::$web : false;
        }

        // Composer autoloader
        $autoloader = dirname(__DIR__).'/Composer/autoload.php';

        if (file_exists($autoloader)) {
            $this->getComposerConfig(include $autoloader);

            // HTML's template directory
            if (static::$html === false) {
                static::$html = static::$php.'Html/';
            }

            //Onm Cli mode
            if (php_sapi_name() === 'cli') {
                return new Devbr\Cli\Main($argv);
            }
        } else {
            throw new Exception("ERROR: Can't find autoloader!", 1);
            return;
        }

        return $this;
    }

    private function getComposerConfig(\Composer\Autoload\ClassLoader $composer)
    {

        $composerPsr4 = $composer->getPrefixesPsr4();

        if (isset($composerPsr4['Devbr\\'])) {
            foreach ($composerPsr4['Devbr\\'] as $dir) {
                static::$psr4[] = realpath($dir).'/';
            }
        }

        $appPhp = $composer->getFallbackDirsPsr4();
        static::$php = realpath(isset($appPhp[0])?$appPhp[0]:'.php/').'/';

        static::$config = realpath(isset($composerPsr4['Config\\'][0])?$composerPsr4['Config\\'][0]:'.php/Config').'/';

        //echo "<b>FallDir: </b> $appPhpDir<br/><b>ConfigDir: </b> $appPhpConfig<br/>".Devbr\App::p($composerPsr4);

        //exit('<pre>'.print_r($composer, true));
    }


    // PRS4 list (array)
    function getPsr4()
    {
        return static::$psr4;
    }

    // PHP path
    function getPhp()
    {
        return static::$php;
    }

    // CONFIG path
    function getConfig()
    {
        return static::$config;
    }

    // WEB
    function setWeb($dir)
    {
        if (!is_string($dir)) {
            return false;
        }
        $dir = realpath($dir);
        static::$web = $dir !== '' ? $dir : false;

        return $this;
    }

    function getWeb()
    {
        return static::$web;
    }

    
    // HTML path
    function setHtml($dir)
    {
        if (!is_string($dir)) {
            return false;
        }
        $dir = realpath($dir);
        static::$html = $dir !== '' ? $dir : false;

        return $this;
    }

    function getHtml()
    {
        return static::$html;
    }


    // IS PHAR
    function setIsPhar($phar)
    {
        if (!is_bool($phar)) {
            return false;
        }
        static::$isPhar = $phar;

        return $this;
    }

    function getIsPhar()
    {
        return static::$isPhar;
    }
    
    // MODE
    function setMode($mode)
    {
        if (!is_numeric($mode)) {
            return false;
        }
        static::$mode = $mode == 0 ? 0 : 1;

        return $this;
    }

    function getMode()
    {
        return static::$mode;
    }

    // --- STATIC ACCESS Fnctions -------------------- (get only)
    
    // PHP path
    static function Php()
    {
        return static::$php;
    }

    // CONFIG path
    static function Config()
    {
        return static::$config;
    }

    // WEB
    static function Web()
    {
        return static::$web;
    }
    
    // HTML path
    static function Html()
    {
        return static::$html;
    }


    // IS PHAR
    static function IsPhar()
    {
        return static::$isPhar;
    }
    
    // MODE
    static function Mode()
    {
        return static::$mode;
    }
}
