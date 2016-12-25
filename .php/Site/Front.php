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
}
