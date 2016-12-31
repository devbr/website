<?php

/**
 * Application resources
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
use Config\Resource;

class App 
{    
    private static $dock = [];
    private static $vars = [];

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
            $url = defined('_URL') ? _URL.$url : $url;
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
        $ext = end((explode('.', $file)));

        $mime = Resource\Mimetype::getMimetype($ext);

        if ($mime) {
            if (is_array($mime)) {
                $mime = $mime[0];
            }
        } else {
            $mime = 'text/plain';
        }

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
