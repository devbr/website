<?php
/**
 * Config\Application
 * PHP version 7
 *
 * @category  Config
 * @package   App
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   0.0.2
 * @link      http://dbrasil.tk/devbr
 */

return new App;

class App
{

    private static $node =   null;

    private static $php =    false;
    private static $config = false;
    private static $web =    false;
    private static $html =   false;

    private static $mode =   0;
    private static $isPhar = false;

    private static $psr4 =   [];

    
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
    public static function this()
    {
        if (is_object(static::$node)) {
            return static::$node;
        }
        //else...
        return static::$node = new static;
    }

   

    public function start($autoloaderPath = null, $webPath = null)
    {
        global $argv;
        
        // Web
        if (static::$web === false) {
            $base = $webPath != null && is_dir($webPath) ? $webPath : dirname(__DIR__);

            static::$web = str_replace('\\', '/', strpos($base, 'phar://') !== false
                            ? dirname(str_replace('phar://', '', $base)).'/'
                            : $base.'/');
        }

        // Is Phar?
        if (static::$isPhar === false) {
            static::$isPhar = strpos(static::$web, 'phar://') !== false ? static::$web : false;
        }

        // Composer autoloader
        $autoloader = $autoloaderPath != null && file_exists($autoloaderPath) ? $autoloaderPath : __DIR__.'/Composer/autoload.php';

        if (file_exists($autoloader)) {
            $this->getComposerConfig(include $autoloader);

            // HTML's template directory
            if (static::$html === false) {
                static::$html = static::$config.'Html/';
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


     /**
     * Switchover back
     *
     * @return void send HTML to browser
     */
    public function welcomePage()
    {
        if (!file_exists(static::$html.'welcome.html')) {
            exit('<html><head><style>h1{font-size:2em;margin:0;padding:5px 0}div{position:absolute;top:50%;left:50%;width:50%;margin:-145px 0 0 -25%;text-align:center}</style></head><body><a href="https://github.com/devbr/website"><div><h1>Hello World!</h1>More info in Github.</div></a></body></html>');
        }
        //\Devbr\App::e(static::$html);
        //call html ...end send
        (new Devbr\Html)->sendPage('welcome', ['title'=>'Hello World'], null, 'main.min', 'main.min');
    }


    public function pageNotFound()
    {
        if (!file_exists(static::$html.'nopage.html')) {
            exit('<html><head><style>h1{font-size:2em;margin:0;padding:5px 0}div{position:absolute;top:50%;left:50%;width:50%;margin:-145px 0 0 -25%;text-align:center}</style></head><body><a href="'._URL.'"><div><h1>Page not found!</h1>Click to homepage.</div></a></body></html>');
        }

        //Else...
        (new Devbr\Html) //->sendCache()
            ->header(false)
            ->body('nopage')
            ->footer(false)

            ->render()
            ->send();
    }



    // ---------------- PRIVATES --------------------

    /**
     * [setDefaults description]
     */
    private function setDefaults()
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


    /**
     * Get Composer Configurations
     *
     * @param  Composer\Autoload\ClassLoader $composer Composer object
     *
     * @return void                                    Void
     */
    private function getComposerConfig(Composer\Autoload\ClassLoader $composer)
    {

        $composerPsr4 = $composer->getPrefixesPsr4();

        if (isset($composerPsr4['Devbr\\'])) {
            foreach ($composerPsr4['Devbr\\'] as $dir) {
                static::$psr4[] = realpath($dir).'/';
            }
        }

        $appPhp = $composer->getFallbackDirsPsr4();
        static::$php = realpath(isset($appPhp[0])?$appPhp[0]:__DIR__).'/';

        static::$config = realpath(isset($composerPsr4['Config\\'][0])?$composerPsr4['Config\\'][0]:__DIR__.'/Config').'/';
    }


    // PRS4 list (array)
    public function getPsr4()
    {
        return static::$psr4;
    }

    // PHP path
    public function getPhp()
    {
        return static::$php;
    }

    // CONFIG path
    public function getConfig()
    {
        return static::$config;
    }

    // WEB
    public function setWeb($dir)
    {
        if (!is_string($dir)) {
            return false;
        }
        $dir = realpath($dir);
        static::$web = $dir !== '' ? $dir : false;

        return $this;
    }

    public function getWeb()
    {
        return static::$web;
    }

    
    // HTML path
    public function setHtml($dir)
    {
        if (!is_string($dir)) {
            return false;
        }
        $dir = realpath($dir);
        static::$html = $dir !== '' ? $dir : false;

        return $this;
    }

    public function getHtml()
    {
        return static::$html;
    }


    // IS PHAR
    public function setIsPhar($phar)
    {
        if (!is_bool($phar)) {
            return false;
        }
        static::$isPhar = $phar;

        return $this;
    }

    public function getIsPhar()
    {
        return static::$isPhar;
    }
    
    // MODE
    public function setMode($mode)
    {
        if (!is_numeric($mode)) {
            return false;
        }
        static::$mode = $mode == 0 ? 0 : 1;

        return $this;
    }

    public function getMode()
    {
        return static::$mode;
    }

    // --- STATIC ACCESS Fnctions -------------------- (get only)
    
    // PHP path
    public static function Php()
    {
        return static::$php;
    }

    // CONFIG path
    public static function Config()
    {
        return static::$config;
    }

    // WEB
    public static function Web()
    {
        return static::$web;
    }
    
    // HTML path
    public static function Html()
    {
        return static::$html;
    }


    // IS PHAR
    public static function IsPhar()
    {
        return static::$isPhar;
    }
    
    // MODE
    public static function Mode()
    {
        return static::$mode;
    }
}
