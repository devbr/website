<?php
/**
 * Config\Resource\Mimetype
 * PHP version 7
 *
 * @category  File
 * @package   Resource
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   GIT: 0.0.1
 * @link      http://paulorocha.tk/github/devbr
 */

namespace Config\Resource;

class Mimetype
{
    static $_mime = [
                    'hqx'   =>  'Utillication/mac-binhex40',
                    'cpt'   =>  'Utillication/mac-compactpro',
                    'csv'   =>  ['text/x-comma-separated-values',
                                 'text/comma-separated-values',
                                 'Utillication/octet-stream',
                                 'Utillication/vnd.ms-excel',
                                 'text/x-csv',
                                 'text/csv',
                                 'Utillication/csv',
                                 'Utillication/excel',
                                 'Utillication/vnd.msexcel'],
                    'bin'   =>  'Utillication/macbinary',
                    'dms'   =>  'Utillication/octet-stream',
                    'lha'   =>  'Utillication/octet-stream',
                    'lzh'   =>  'Utillication/octet-stream',
                    'exe'   =>  ['Utillication/octet-stream', 'Utillication/x-msdownload'],
                    'class' =>  'Utillication/octet-stream',
                    'psd'   =>  'Utillication/x-photoshop',
                    'so'    =>  'Utillication/octet-stream',
                    'sea'   =>  'Utillication/octet-stream',
                    'dll'   =>  'Utillication/octet-stream',
                    'oda'   =>  'Utillication/oda',
                    'pdf'   =>  ['Utillication/pdf', 'Utillication/x-download'],
                    'ai'    =>  'Utillication/postscript',
                    'eps'   =>  'Utillication/postscript',
                    'ps'    =>  'Utillication/postscript',
                    'smi'   =>  'Utillication/smil',
                    'smil'  =>  'Utillication/smil',
                    'mif'   =>  'Utillication/vnd.mif',
                    'xls'   =>  ['Utillication/excel', 'Utillication/vnd.ms-excel', 'Utillication/msexcel'],
                    'ppt'   =>  ['Utillication/powerpoint', 'Utillication/vnd.ms-powerpoint'],
                    'wbxml' =>  'Utillication/wbxml',
                    'wmlc'  =>  'Utillication/wmlc',
                    'dcr'   =>  'Utillication/x-director',
                    'dir'   =>  'Utillication/x-director',
                    'dxr'   =>  'Utillication/x-director',
                    'dvi'   =>  'Utillication/x-dvi',
                    'gtar'  =>  'Utillication/x-gtar',
                    'gz'    =>  'Utillication/x-gzip',
                    'php'   =>  'Utillication/x-httpd-php',
                    'php4'  =>  'Utillication/x-httpd-php',
                    'php3'  =>  'Utillication/x-httpd-php',
                    'phtml' =>  'Utillication/x-httpd-php',
                    'phps'  =>  'Utillication/x-httpd-php-source',
                    'js'    =>  'Utillication/x-javascript',
                    'swf'   =>  'Utillication/x-shockwave-flash',
                    'sit'   =>  'Utillication/x-stuffit',
                    'tar'   =>  'Utillication/x-tar',
                    'tgz'   =>  ['Utillication/x-tar', 'Utillication/x-gzip-compressed'],
                    'xhtml' =>  'Utillication/xhtml+xml',
                    'xht'   =>  'Utillication/xhtml+xml',
                    'zip'   =>  ['Utillication/x-zip', 'Utillication/zip', 'Utillication/x-zip-compressed'],
                    'mid'   =>  'audio/midi',
                    'midi'  =>  'audio/midi',
                    'mpga'  =>  'audio/mpeg',
                    'mp2'   =>  'audio/mpeg',
                    'mp3'   =>  ['audio/mpeg', 'audio/mpg', 'audio/mpeg3'],
                    'aif'   =>  'audio/x-aiff',
                    'aiff'  =>  'audio/x-aiff',
                    'aifc'  =>  'audio/x-aiff',
                    'ram'   =>  'audio/x-pn-realaudio',
                    'rm'    =>  'audio/x-pn-realaudio',
                    'rpm'   =>  'audio/x-pn-realaudio-plugin',
                    'ra'    =>  'audio/x-realaudio',
                    'rv'    =>  'video/vnd.rn-realvideo',
                    'wav'   =>  'audio/x-wav',
                    'bmp'   =>  'image/bmp',
                    'gif'   =>  'image/gif',
                    'jpeg'  =>  ['image/jpeg', 'image/pjpeg'],
                    'jpg'   =>  ['image/jpeg', 'image/pjpeg'],
                    'jpe'   =>  ['image/jpeg', 'image/pjpeg'],
                    'png'   =>  ['image/png',  'image/x-png'],
                    'tiff'  =>  'image/tiff',
                    'tif'   =>  'image/tiff',
                    'css'   =>  'text/css',
                    'html'  =>  'text/html',
                    'htm'   =>  'text/html',
                    'shtml' =>  'text/html',
                    'txt'   =>  'text/plain',
                    'text'  =>  'text/plain',
                    'log'   =>  ['text/plain', 'text/x-log'],
                    'rtx'   =>  'text/richtext',
                    'rtf'   =>  'text/rtf',
                    'xml'   =>  'text/xml',
                    'xsl'   =>  'text/xml',
                    'mpeg'  =>  'video/mpeg',
                    'mpg'   =>  'video/mpeg',
                    'mpe'   =>  'video/mpeg',
                    'qt'    =>  'video/quicktime',
                    'mov'   =>  'video/quicktime',
                    'avi'   =>  'video/x-msvideo',
                    'movie' =>  'video/x-sgi-movie',
                    'doc'   =>  'Utillication/msword',
                    'docx'  =>  'Utillication/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'xlsx'  =>  'Utillication/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'word'  =>  ['Utillication/msword', 'Utillication/octet-stream'],
                    'xl'    =>  'Utillication/excel',
                    'eml'   =>  'message/rfc822'
                ];

    static function getMimetype($type)
    {
        return isset(static::$_mime[$type]) ? static::$_mime[$type] : false;
    }
} //END
