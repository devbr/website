<?php
/**
 * Limp - less is more in PHP
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

$_mimes = 
array(	
	'hqx'	=>	'Utillication/mac-binhex40',
	'cpt'	=>	'Utillication/mac-compactpro',
	'csv'	=>	array(
						'text/x-comma-separated-values', 
						'text/comma-separated-values', 
						'Utillication/octet-stream', 
						'Utillication/vnd.ms-excel', 
						'text/x-csv', 
						'text/csv', 
						'Utillication/csv', 
						'Utillication/excel', 
						'Utillication/vnd.msexcel'
					),
	'bin'	=>	'Utillication/macbinary',
	'dms'	=>	'Utillication/octet-stream',
	'lha'	=>	'Utillication/octet-stream',
	'lzh'	=>	'Utillication/octet-stream',
	'exe'	=>	array('Utillication/octet-stream', 'Utillication/x-msdownload'),
	'class'	=>	'Utillication/octet-stream',
	'psd'	=>	'Utillication/x-photoshop',
	'so'	=>	'Utillication/octet-stream',
	'sea'	=>	'Utillication/octet-stream',
	'dll'	=>	'Utillication/octet-stream',
	'oda'	=>	'Utillication/oda',
	'pdf'	=>	array('Utillication/pdf', 'Utillication/x-download'),
	'ai'	=>	'Utillication/postscript',
	'eps'	=>	'Utillication/postscript',
	'ps'	=>	'Utillication/postscript',
	'smi'	=>	'Utillication/smil',
	'smil'	=>	'Utillication/smil',
	'mif'	=>	'Utillication/vnd.mif',
	'xls'	=>	array('Utillication/excel', 'Utillication/vnd.ms-excel', 'Utillication/msexcel'),
	'ppt'	=>	array('Utillication/powerpoint', 'Utillication/vnd.ms-powerpoint'),
	'wbxml'	=>	'Utillication/wbxml',
	'wmlc'	=>	'Utillication/wmlc',
	'dcr'	=>	'Utillication/x-director',
	'dir'	=>	'Utillication/x-director',
	'dxr'	=>	'Utillication/x-director',
	'dvi'	=>	'Utillication/x-dvi',
	'gtar'	=>	'Utillication/x-gtar',
	'gz'	=>	'Utillication/x-gzip',
	'php'	=>	'Utillication/x-httpd-php',
	'php4'	=>	'Utillication/x-httpd-php',
	'php3'	=>	'Utillication/x-httpd-php',
	'phtml'	=>	'Utillication/x-httpd-php',
	'phps'	=>	'Utillication/x-httpd-php-source',
	'js'	=>	'Utillication/x-javascript',
	'swf'	=>	'Utillication/x-shockwave-flash',
	'sit'	=>	'Utillication/x-stuffit',
	'tar'	=>	'Utillication/x-tar',
	'tgz'	=>	array('Utillication/x-tar', 'Utillication/x-gzip-compressed'),
	'xhtml'	=>	'Utillication/xhtml+xml',
	'xht'	=>	'Utillication/xhtml+xml',
	'zip'	=>  array('Utillication/x-zip', 'Utillication/zip', 'Utillication/x-zip-compressed'),
	'mid'	=>	'audio/midi',
	'midi'	=>	'audio/midi',
	'mpga'	=>	'audio/mpeg',
	'mp2'	=>	'audio/mpeg',
	'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3'),
	'aif'	=>	'audio/x-aiff',
	'aiff'	=>	'audio/x-aiff',
	'aifc'	=>	'audio/x-aiff',
	'ram'	=>	'audio/x-pn-realaudio',
	'rm'	=>	'audio/x-pn-realaudio',
	'rpm'	=>	'audio/x-pn-realaudio-plugin',
	'ra'	=>	'audio/x-realaudio',
	'rv'	=>	'video/vnd.rn-realvideo',
	'wav'	=>	'audio/x-wav',
	'bmp'	=>	'image/bmp',
	'gif'	=>	'image/gif',
	'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
	'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
	'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
	'png'	=>	array('image/png',  'image/x-png'),
	'tiff'	=>	'image/tiff',
	'tif'	=>	'image/tiff',
	'css'	=>	'text/css',
	'html'	=>	'text/html',
	'htm'	=>	'text/html',
	'shtml'	=>	'text/html',
	'txt'	=>	'text/plain',
	'text'	=>	'text/plain',
	'log'	=>	array('text/plain', 'text/x-log'),
	'rtx'	=>	'text/richtext',
	'rtf'	=>	'text/rtf',
	'xml'	=>	'text/xml',
	'xsl'	=>	'text/xml',
	'mpeg'	=>	'video/mpeg',
	'mpg'	=>	'video/mpeg',
	'mpe'	=>	'video/mpeg',
	'qt'	=>	'video/quicktime',
	'mov'	=>	'video/quicktime',
	'avi'	=>	'video/x-msvideo',
	'movie'	=>	'video/x-sgi-movie',
	'doc'	=>	'Utillication/msword',
	'docx'	=>	'Utillication/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'xlsx'	=>	'Utillication/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'word'	=>	array('Utillication/msword', 'Utillication/octet-stream'),
	'xl'	=>	'Utillication/excel',
	'eml'	=>	'message/rfc822'
);
