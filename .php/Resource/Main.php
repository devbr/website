<?php
/**
 * Resource\Main
 * PHP version 7
 *
 * @category  Controller
 * @package   Resource
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   GIT: 0.0.1
 * @link      http://paulorocha.tk/devbr
 */

namespace Resource;

use Devbr;
use Devbr\App;

/**
 * Main Class
 *
 * @category Controller
 * @package  Resource
 * @author   Bill Rocha <prbr@ymail.com>
 * @license  <https://opensource.org/licenses/MIT> MIT
 * @link     http://paulorocha.tk/devbr
 */
class Main
{
    public $model = null;
    public $key = null;
    public $params = null;
    public $request = null;

    public $userId = 0;

    public $scripts = ['all'];
    public $styles = ['all'];

    public $pathScript = false;
    public $pathStyle = false;

    public $navbar = null;

    public $patchHtml = '';
    public $header = false;
    public $footer = false;
    public $pageName = null;


    /** Abstratic Controller constructor
     *  -- Bypass it in your controller
     */
    function __construct($config = [])
    {
        $this->patchHtml = \Config\App::Html();
        
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
        if (!file_exists(\Config\App::Html().'home.html')) {
            exit('<style>h1{font-size:2em;margin:0;padding:5px 0}div{position:absolute;top:50%;left:50%;width:50%;margin:-145px 0 0 -25%;text-align:center}</style><a href="https://github.com/devbr/website"><div><h1>Hello World!</h1>More info in Github.</div></a>');
        }
        //Configuration of style & script
        $this->scripts = ['main.min'];
        $this->styles  = ['main.min'];

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
        if (!file_exists(\Config\App::Html().'nopage.html')) {
            exit('<style>h1{font-size:2em;margin:0;padding:5px 0}div{position:absolute;top:50%;left:50%;width:50%;margin:-145px 0 0 -25%;text-align:center}</style><a href="'._URL.'"><div><h1>Page not found!</h1>Click to homepage.</div></a>');
        }

        //Else...
        (new Devbr\Html('nopage'))//->sendCache()
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
            $this->key = (new Devbr\User)->getToken($rec->id);
            $this->userId = $rec->id;
            if ($this->key === false) {
                return false;
            }

            //Decriptando
            Devbr\Aes::size(256);
            return ['data' => $rec, 'dec' => json_decode(Devbr\Aes::dec($rec->enc, $this->key))];
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
        Devbr\Aes::size(256);
        $enc = Devbr\Aes::enc($enc, $this->key);

        //Enviando
        exit($enc);
    }



    final public function sendPage($page, $data = null, $jsvar = null)
    {
        $html = new Devbr\Html();
        $html->setPathHtml($this->patchHtml)
             ->body($page)
             ->header($this->header)
             ->footer($this->footer)
             ->setName($this->pageName)
             ->insertScripts($this->scripts)
             ->insertStyles($this->styles)
             ->val($data)
             ->jsvar($jsvar)
             ->render()
             ->send();
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
       
        $d = new Devbr\Html(null, ($name === null ? 'body' : $name));

        if ($this->patchHtml !== null) {
            $d->setPathHtml($this->patchHtml);
        }
        
        if ($this->navbar !== null) {
            $d->body($this->navbar);
        }

        $d->body($body);

        if ($template === false) {
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
