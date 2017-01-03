<?php
/**
 * Site\Front
 * PHP version 7
 *
 * @category  Site
 * @package   Controller
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   GIT: 0.0.4
 * @link      http://paulorocha.tk/github/devbr
 */

namespace Site;

use Resource\Main;

/**
 * Front Class
 *
 * @category Site
 * @package  Controller
 * @author   Bill Rocha <prbr@ymail.com>
 * @license  <https://opensource.org/licenses/MIT> MIT
 * @link     http://paulorocha.tk/github/devbr
 */
class Front extends Main
{
    
    public $styles = ['home'];
    public $scripts = ['main'];

    /**
     * Front page
     *
     * @return void Send HTML front page
     */
    function page()
    {
        $this->response('home', ['title'=>'Hello World']);
    }
    
    /**
     * Test access
     *
     * @param string $rqst  URI requested from user
     * @param array  $param Array of parameters captured by the router
     *
     * @return void Send HTML contents
     */
    function test($rqst, $param)
    {
        echo '<h1>Test</h1>'.
             '<br><b>Request: </b>'.$rqst.
             '<br><b>Params: </b><pre>'.print_r($param, true).'</pre>';
    }
}
