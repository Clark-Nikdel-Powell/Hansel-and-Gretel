<?php
namespace HAG\Elements;

class Comment extends Base {

	public function __construct()
	{
		parent::__construct();
		$this->separator = PHP_EOL.PHP_EOL;
	}

	public function open() 
	{
		return '<!--'.PHP_EOL;
	}

	public function close() 
	{
		return PHP_EOL.'-->';
	}

}
