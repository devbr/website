<?php
/*
 * CAN - Código Alfa Numérico
 * Classe para converter um valor numérico em CAN e de volta à numérico.
 * @copyright   Bill Rocha - http://plus.google.com/+BillRocha
 * @license     MIT & GLP2
 * @author      Bill Rocha - prbr@ymail.com
 * @version     0.0.1
 * @package     Lib
 * @access      public
 * @since       0.0.4
 * @date        2015/08/30-19:00:00


    digitos      -      resolução

    1  =                        64
    2  =                     4.096
    3  =                   262.144
    4  =                16.777.216
    5  =             1.073.741.824
    6  =            68.719.476.736 ( 68 bilhões )
    7  =         4.398.046.511.104
    8  =       281.474.976.710.656
    9  =    18.014.398.509.481.984
    10 = 1.152.921.504.606.846.976 ( 1 quinquilhão )
    
    Usando $extra_base com 79 índices pode chegar a:
    10 = 9.468.276.082.626.847.201 ( 9.4 quinquilhões )


    Exemplo:

    $can = new Can();
    $can->encode(50000) => "ntW"
    $can->decode("ntW") => 50000

    Depende do arquivo com a chave aleatória (gerada na instalação da aplicação)
    define('_CONFIG', 'path/to/config/file/');

    Use "Lib" para gerar uma chave aleatória:
    >> php Lib key:generate [enter]

*/

namespace Lib;

class Can
{

    private $number = 0;
    private $can = '';
    private $resolution = 10;
    private $useExtra = false;


    static $base = ['$','_','0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

    static $extra_base = ['$','!','#','%','&','*','+','-','?','@','(',')','/','\\','[',']','_','0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

    /*
     *
     */

    function __construct($resolution = 10, $extra = false){
        if((0 + $resolution) > 0){
            $this->resolution = 0 + $resolution;
        }

        if($extra) $this->useExtra = true;

        //get "base" key OR use default
        if(file_exists(_CONFIG.'Key/can.key')){
            $base = file_get_contents(_CONFIG.'Key/can.key');
            static::$base = [];
            static::$extra_base = [];
            $base = explode("\n", $base);

            for($i = 0; $i < strlen($base[0]); $i ++){
                static::$base[] = $base[0][$i];
            }
            for($i = 0; $i < strlen($base[1]); $i ++){
                static::$extra_base[] = $base[1][$i];
            }
        }
    }

    /* Codifica um valor numérico em CAN ( ex.: 63.145 > GQT )
     * Parametro forceWidth: true - completa com base[0] os campos com valor "0" à esquerda
     *                       false - mostra somente os caracteres que fazem diferença.
     * Ex.: encode(1)       => 'u'
     *      encode(1, true) => 'IIIIIIIIIu';
     *
     */
    function encode($num = null, $forceWidth = false){
        if($num !== null && (0 + $num) >= 0) $this->number = 0 + $num;

        //overflow...
        if($this->number >= bcpow(64, $this->resolution)) return false;

        $res = '';
        $num = $this->number;
        $himem = false;

        for($i = $this->resolution; $i >= 1; $i--){
            if($num <= 0) {
                $res .= $this->useExtra ? static::$extra_base[0] : static::$base[0];
                continue;
            }
            $ind = bcpow(64, $i-1);
            $a = intval($num/$ind);
            if($a > 0) $himem = true;
            $num = $num - ($a*$ind);
            if($himem || $forceWidth) $res .= $this->useExtra ? static::$extra_base[$a] : static::$base[$a];
        }
        $this->can = $res;
        return $this->can;
    }

    //Decodifica uma string CAN para um valor numérico ( ex.: GQT > 63.145 )
    function decode($can = null){
        if($can != null && is_string($can)) $this->can = $can;

        $len = strlen($this->can) -1;
        $valor = 0;
        for($i = $len; $i >= 0; $i--){
            $peso = bcpow(64, $i);
            $d = substr($this->can, $len-$i, 1);
            $c = array_search($d, $this->useExtra ? static::$extra_base : static::$base);

            if($c === false) return false;
            $valor += $peso * $c;
        }

        $this->number = $valor;
        return $this->number;
    }
}
