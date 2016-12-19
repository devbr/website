<?php
/**
 * Home Controller
* 
*/

namespace Site;

use Resource\Main;

class Page extends Main
{
	
	public $styles = ['home'];
	public $scripts = ['main'];

	function index()
	{
		$this->response('home',['title'=>'Hello World']);
	}
}
