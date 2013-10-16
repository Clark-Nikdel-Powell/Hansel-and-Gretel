<?php
namespace HAG\Elements;

class DebugSection extends Base {

	public function __construct($title)
	{
		parent::__construct();
		
		$headingLength = 80;
		$paddingChar = '#';

		$titleLength = strlen($title) + 2; //for *fixed spaces
		$paddingLength = ($headingLength - $titleLength) / 2;

		$heading = array_pad(array(), floor($paddingLength), $paddingChar);
		$heading[] = " $title ";
		$heading = array_pad($heading, $headingLength, $paddingChar);

		$this->appendChild(implode('', $heading));
		$this->appendChild(PHP_EOL);
		$this->setSeparator(PHP_EOL);
	}

}
