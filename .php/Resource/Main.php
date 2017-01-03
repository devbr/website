<?php
/**
 * Limp - less is more in PHP
 * @copyright   Bill Rocha - http://google.com/+BillRocha
 * @license     MIT
 * @author      Bill Rocha - prbr@ymail.com
 * @version     0.0.1
 * @package     Resource
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

namespace Resource;

use Lib;
use Lib\App;

class Main
{
    public $model = null;
    public $key = null;
    public $params = null;
    public $request = null;

    public $userId = 0;

    public $scripts = ['all'];
    public $styles = ['all'];

    public $navbar = null;


    /** Abstratic Controller constructor
     *  -- Bypass it in your controller
     */
    function __construct($config = [])
    {
        if (isset($config['params'])) {
            $this->params = $config['params'];
        }
        if (isset($config['request'])) {
            $this->request = $config['request'];
        }

        //if Twig teplate engine is required
        if (isset($this->twig)
            && $this->twig == true) {
            $this->twig = \Config\Twig\Twig::this();
        }
    }

    /**
     * Switchover back
     *
     * @return void send HTML to browser
     */
    function index()
    {
        //Configuration of style & script
        $this->scripts = ['main'];
        $this->styles  = ['home'];

        //call html ...end send
        $this->response('home', ['title'=>'Hello World']);
    }


    /**
     * Test access
     * DELETE --> it's only for EXAMPLE
     *
     * @param string $rqst  URI requested from user
     * @param array  $param Array of parameters captured by the router
     *
     * @return void Send HTML contents
     */
    function indexTest($rqst, $param)
    {
        echo '<h1>Test</h1>'.
             '<br><b>Request: </b>'.$rqst.
             '<br><b>Params: </b><pre>'.print_r($param, true).'</pre>';
    }

    
    function pageNotFound()
    {
        (new Lib\Html('nopage'))//->sendCache()
                                ->header(false)
                                ->body('nopage')
                                ->footer(false)
                                ->render()
                                ->send();
    }


    /** Decodifica entrada via Post
     *
     *
     */
    final function decodePostData()
    {
        if (!isset($_POST['data'])) {
            return false;
        }
        $rec = json_decode($_POST['data']);

        //Se não for JSON...
        if (!is_object($rec)) {
            return false;
        }

        if (isset($rec->enc)) {
            $this->key = (new Lib\User)->getToken($rec->id);
            $this->userId = $rec->id;
            if ($this->key === false) {
                return false;
            }

            //Decriptando
            Lib\Aes::size(256);
            return ['data' => $rec, 'dec' => json_decode(Lib\Aes::dec($rec->enc, $this->key))];
        }
        return ['data' => $rec];
    }

    /** Envia dados criptografados para o browser
     *
     *
     */
    final function sendEncriptedData($dt)
    {
        //Json encoder
        $enc = json_encode($dt);

        //Encriptando
        Lib\Aes::size(256);
        $enc = Lib\Aes::enc($enc, $this->key);

        //Enviando
        exit($enc);
    }


    /**
     * Cria, configura e retorna o HTML para o usuário
     */
    public function response(
        $body,
        $var = null,
        $name = null,
        $jsvar = null,
        $scripts = null,
        $styles = null,
        $template = null
    ) {
       
        $d = new Lib\Html(($name === null ? 'body' : $name));
        
        if ($this->navbar !== null) {
            $d->body($this->navbar);
        }

        $d->body($body);

        if ($name === false) {
            $d->header(false);
            $d->footer(false);
        }

        if ($var !== null) {
            foreach ($var as $k => $v) {
                $d->val($k, $v);
            }
        }

        if ($jsvar !== null) {
            foreach ($jsvar as $k => $v) {
                $d->jsvar($k, $v);
            }
        }

        if ($scripts !== null) {
            $this->scripts = array_merge($this->scripts, $scripts);
        }
        if ($styles !== null) {
            $this->styles  = array_merge($this->styles, $styles);
        }

        $d->insertScripts($this->scripts);
        $d->insertStyles($this->styles);
        
        return $d->render()->send();
    }


    /**
     * Pivo de ação
     */
    final public function action()
    {
        $rec = $this->decodePostData();

        if ($rec == false) {
            $this->sendEncriptedData(['error'=>'Token inválido!']);
        }

        $dec = $rec['dec'];
        switch ($dec->action) {
            case 'resumo':
                return $this->resumo($dec->table, $dec->data, $this->userId);
                break;
            case 'delete':
                return $this->delete($dec->table, $dec->data, $this->userId);
                break;

            case 'get':
                return $this->get($dec->table, $dec->data, $this->userId);
                break;

            case 'save':
                //Object to Array
                $values = get_object_vars($dec->row);
                
                //Select DB action: update/insert and get hook
                if (isset($values['id']) && (0+$values['id'] < 0 || $values['id'] !== '')) {
                    return $this->update($dec->table, $values);
                } else {
                    unset($values['id']);
                    return $this->insert($dec->table, $values);
                }
                break;
        }
    }
}
