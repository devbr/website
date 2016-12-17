<?php

/**
 * NEOS PHP FRAMEWORK
 * @copyright   Bill Rocha - http://plus.google.com/+BillRocha
 * @license     MIT
 * @author      Bill Rocha - prbr@ymail.com
 * @version     0.0.1
 * @package     Lib
 * @access      public
 * @since       0.3.0
 *
 */

namespace Lib;

use Lib;

class App 
{    
    private static $url = '';
    private static $pathConfig = '';

    private static $dock = [];
    private static $vars = [];

    static function url($url = null) 
    {
        if($url === null) return static::$url;
        return static::$url = rtrim($url, ' \\/').'/';;
    }

    static function pathConfig($cfg = null) 
    {
        if($cfg === null) return static::$pathConfig;
        return static::$pathConfig = rtrim($cfg, ' \\/').'/';
    }

    /* Set/Get variables
     * name = value par
     *
     */
    static function val($name, $value = null) 
    {
        if ($value === null) return static::$vars[$name];
        return static::$vars[$name] = $value;
    }

    /* Parking Objects
     * 
     */
    static function push($name, $object) 
    {
        static::$dock[$name] = $object;
    }

    static function pull($name) 
    {
        return isset(static::$dock[$name]) ? static::$dock[$name] : false;
    }

    /* Jump to...
     *
     */
    static function go($url = '', $type = 'location', $cod = 302) 
    {
        //se tiver 'http' na uri então será externo.
        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false){
            $url = defined('_URL') ? _URL.$url : static::$url.$url;
        }

        //send header
        if (strtolower($type) == 'refresh')
            header('Refresh:0;url=' . $url);
        else
            header('Location: ' . $url, TRUE, $cod);

        //... and stop
        exit;
    }

    //Download de arquivo em modo PHAR (interno)
    static function download($file) {

        //checando a existencia do arquivo solicitado
        if(!file_exists($file)) return false;

        //gerando header apropriado
        include static::$pathConfig.'Neos/mimetypes.php';
        $ext = end((explode('.', $file)));
        if (!isset($_mimes[$ext])) $mime = 'text/plain';
        else $mime = (is_array($_mimes[$ext])) ? $_mimes[$ext][0] : $_mimes[$ext];

        //get file
        $content = file_get_contents($file);

        //download
        ob_end_clean();
        ob_start('ob_gzhandler');

        header('Vary: Accept-Language, Accept-Encoding');
        header('Content-Type: ' . $mime);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT');
        header('Cache-Control: must_revalidate, public, max-age=31536000');
        header('Content-Length: ' . strlen($content));
        header('Content-Disposition: attachment; filename='.basename($file)); 
        header('ETAG: '.md5($file));
        exit($content);
    }

    //Print mixed data and exit
    static function e($v) { exit(static::p($v)); }
    static function p($v, $echo = false) {
        $tmp = '<pre>' . print_r($v, true) . '</pre>';
        if ($echo) echo $tmp;
        else return $tmp;
    }

}
