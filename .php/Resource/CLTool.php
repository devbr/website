<?php
/**
 * Resource\CLTool
 * PHP version 7
 *
 * @category  CLT
 * @package   Resource
 * @author    Bill Rocha <prbr@ymail.com>
 * @copyright 2016 Bill Rocha <http://google.com/+BillRocha>
 * @license   <https://opensource.org/licenses/MIT> MIT
 * @version   GIT: 0.0.2
 * @link      http://paulorocha.tk/github/devbr
 */

namespace Resource;

use Lib;

/**
 * CLTool Class
 *
 * @category CLT
 * @package  Resource
 * @author   Bill Rocha <prbr@ymail.com>
 * @license  <https://opensource.org/licenses/MIT> MIT
 * @link     http://paulorocha.tk/github/devbr
 */
class CLTool
{

    private $configKeyPath = null;
    private $configTemplate = null;
    private $timer = 0;

    function __construct($argv)
    {
        echo '  Command Line Tool!';
        if (php_sapi_name() !== 'cli') {
            exit('It\'s no cli!');
        }

        //Constants:
        $this->configKeyPath = _CONFIG.'Key/';
        $this->configTemplate = _CONFIG.'Template/';
        $this->timer = microtime(true);

        //Command line settings...
        echo $this->request($argv);

        exit("\n  Finished in ".number_format((microtime(true)-$this->timer)*1000, 3)." ms.\n");
    }

    //CORE Request
    function request($rqst)
    {
        array_shift($rqst);
        $ax = $rqst;
        foreach ($rqst as $a) {
            array_shift($ax);
            if (strpos($a, '-h') !== false || strpos($a, '?') !== false) {
                return $this->help();
            }
            if (strpos($a, 'optimize') !== false) {
                return $this->cmdOptimize(substr($a, 8), $ax);
            }
            if (strpos($a, 'install') !== false) {
                return $this->cmdInstall(substr($a, 7), $ax);
            }
            if (strpos($a, 'update') !== false) {
                return $this->cmdUpdate(substr($a, 6), $ax);
            }
            if (strpos($a, 'key:') !== false) {
                return $this->cmdKey(substr($a, 4), $ax);
            }
            if (strpos($a, 'make:') !== false) {
                return $this->cmdMake(substr($a, 5), $ax);
            }

            //Plugins
            if (strpos($a, 'table:') !== false) {
                $plugin = new Plugin\Table(substr($a, 6), $ax);
                return $plugin->run();
            }
        }
        //or show help...
        return $this->help();
    }

    //Command KEY
    function cmdKey($v, $arg)
    {
        echo '  key: '.$v;

        if (count($arg) > 0) {
            echo "\n\n  Arguments:";
            foreach ($arg as $a) {
                echo "\n\t$a";
            }
        }

        if ($v == 'generate') {
            //check if path exists
            if (!is_dir($this->configKeyPath)) {
                $this->checkAndOrCreateDir($this->configKeyPath, true);
            }

            //Now, OPEN_SSL
            $this->createKeys();
            echo "\n  Can, OpenSSL keys & certificates - created success!";
            return "\n  Location: ".$this->configKeyPath."\n\n";
        } elseif ($v == 'list') {
            echo "\n\n  Ciphers:";
            foreach (mcrypt_list_algorithms() as $x) {
                echo "\n\t".$x;
            }
            echo "\n\n  Cipher Modes:";
            foreach (mcrypt_list_modes() as $x) {
                echo "\n\t".$x;
            }
        } else {
            return "\n\n  ----- ERROR: Command 'key:$v' not found!\n".$this->help();
        }
    }

    //Command MAKE
    function cmdMake($v, $arg)
    {
        echo '  make: '.$v;

        if (isset($arg[0])) {
            $arg[0] = str_replace('\\', '/', $arg[0]);
        } else {
            return "\n\n  ERROR: indique o NOME do arquivo!\n";
        }

        $type = strtolower(trim($v));

        if ($type != 'controller' && $type != 'model' && $type != 'html') {
            return "\n\n  ----- ERROR: Command 'make:$v' not found!\n".$this->help();
        }

        return $this->createFile($arg[0], $type);
    }

    //Command OPTIMIZE
    function cmdOptimize($v, $arg)
    {
        //TODO : optimize!
        echo "\n  >> Optimized - success!\n";
    }

    //Command INSTALL
    function cmdInstall($v, $arg)
    {
        //TODO : optimize!
        echo "\n  >> Installed - success!\n";
    }

    //Command UPDATE
    function cmdUpdate($v, $arg)
    {
        $devbr = _APP.'Composer/devbr/';
        $dir = scandir($devbr);

        foreach ($dir as $k) {
            if ($k == '.' || $k == '..') {
                continue;
            }
            if (is_file($devbr.$k.'/install')) {
                echo include $devbr.$k.'/install';
            }
        }
        echo "\n  >> Updated - success!\n";
    }

    // Checa um diretório e cria se não existe - retorna false se não conseguir ou não existir
    function checkAndOrCreateDir($dir, $create = false, $perm = '0777')
    {
        if (is_dir($dir) && is_writable($dir)) {
            return true;
        } elseif ($create === false) {
            return false;
        }

        @mkdir($dir, $perm, true);
        @chmod($dir, $perm);

        if (is_writable($dir)) {
            return true;
        }
        return false;
    }

    // Create file (controller/model/library)
    function createFile($name, $type = 'controller')
    {
        //$name = $type == 'html'?strtolower($name):$name;
        $path = _APP.ucfirst($type).'/';
        $ext = $type == 'html'?'.html':'.php';

        $fileName = _APP.$name.$ext;

        if (file_exists($fileName)) {
            return "\n\n  WARNNING: this file already exists!\n  ".$fileName."\n\n";
        }


        if (!$this->checkAndOrCreateDir(dirname($fileName), true)) {
            return "\n\n  WARNNING: access denied in directory '".dirname($fileName)."'\n\n";
        }

        //get template
        $file = file_get_contents($this->configTemplate.$type.'.tpl');

        //replace %namespace% and %name%
        $file = str_replace('%name%', ucfirst(basename($name)), $file);
        $namespace = '';
        foreach (explode('/', dirname($name)) as $namespc) {
            if ($namespc == '.') {
                break;
            }
            $namespace .= ucfirst($namespc).'\\';
        }
        $file = str_replace('%namespace%', trim($namespace, '\\'), $file);

        //saving the file
        $ok = file_put_contents($fileName, $file);

        if ($ok) {
            return "\n\n  Arquivo '".$fileName."' criado com sucesso!\n\n";
        } else {
            return "\n\n  Não foi possível criar '".$name."'!\n\n";
        }
    }


    /* Create Can and SSl keys
     * 
     */
    function createKeys()
    {
        //Create Can Keys
        shuffle(Lib\Can::$base);
        shuffle(Lib\Can::$extra_base);
        file_put_contents($this->configKeyPath.'can.key', implode(Lib\Can::$base)."\n".implode(Lib\Can::$extra_base));

        $SSLcnf = [];
        $dn = [];

        //get configurations
        include $this->configKeyPath.'openssl.config.php';

        // Generate a new private (and public) key pair
        $privkey = openssl_pkey_new($SSLcnf);

        // Generate a certificate signing request
        $csr = openssl_csr_new($dn, $privkey, $SSLcnf);

        // You will usually want to create a self-signed certificate at this
        // point until your CA fulfills your request.
        // This creates a self-signed cert that is valid for 365 days
        $sscert = openssl_csr_sign($csr, null, $privkey, 365, $SSLcnf);

        //CERTIFICADO
        openssl_csr_export_to_file($csr, $this->configKeyPath.'certificate.crt', false);

        //CERTIFICADO AUTO-ASSINADO
        openssl_x509_export_to_file($sscert, $this->configKeyPath.'self_signed_certificate.cer', false);

        //CHAVE PRIVADA (private.pem)
        openssl_pkey_export_to_file($privkey, $this->configKeyPath.'private.key', null, $SSLcnf);

        //CHAVE PÚBLICA (public.key)
        return file_put_contents($this->configKeyPath.'public.key', openssl_pkey_get_details($privkey)['key']);
    }

    //Help display
    function help()
    {
        return '
      Usage: php index.php [command:type] [options]

      key:generate              Generate new keys
      key:list                  List all installed Cyphers

      make:controller <name>    Create a controller with <name>
      make:model <name>         Create a model with <name>
      make:html <name>          Create a html file with <name>

      optimize                  Optimize entire Limp application

      -h or ?                   Show this help
      ';
    }
}
