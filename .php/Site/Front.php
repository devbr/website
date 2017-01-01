<?php
/**
 * Site Front Page 
*/

namespace Site;

use Resource\Main;

class Front extends Main
{
	
	public $styles = ['home'];
	public $scripts = ['main'];

	function page()
	{
		$this->response('home',['title'=>'Hello World']);
	}
	
	function test($rqst, $param)
	{
		echo '<h1>Test</h1>'.
			 '<br><b>Request: </b>'.$rqst.
			 '<br><b>Params: </b><pre>'.print_r($param, true).'</pre>';
	}
}
