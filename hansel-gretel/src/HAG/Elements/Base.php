<?php
namespace HAG\Elements;

class Base {

	protected $tag;	
	protected $prefix;
	protected $separator;
	protected $suffix;
	protected $attributes;
	protected $children;

/****************************************************************************
 * CONSTRUCTION
 ****************************************************************************/

	public function __construct() 
	{
		$this->tag = false;
		$this->prefix = false;
		$this->suffix = false;
		$this->separator = false;
		$this->children = array();
		$this->attributes = array();
	}

	public function setTag($tag) 
	{
		$this->tag = $this->sanitizeTag($tag);
	}

	public function setPrefix($prefix) 
	{
		$this->prefix = $prefix;
	}

	public function setSuffix($suffix) 
	{
		$this->suffix = $suffix;
	}

	public function setSeparator($separator)
	{
		$this->separator = $separator;
	}

	public function setId($id) 
	{
		$id = $this->sanitizeId($id);
		$this->setAttribute('id', $id);
	}

	public function setClasses($classes) 
	{
		if (is_array($classes)) $classes = implode(' ', $classes);
		$classes = $this->sanitizeClass($classes);
		$this->setAttribute('class', $classes);
	}

	public function setAttribute($name, $value) 
	{
		$name = $this->sanitizeId(strtolower($name));
		$this->attributes[$name] = $value;
	}

	public function appendChild($child)
	{
		$this->children[] = $child;
	}

/****************************************************************************
 * DISPLAY
 ****************************************************************************/

	public function open() 
	{
		$output = array();

		if($this->tag) {
			$output[] = "<$this->tag";
			foreach($this->attributes as $name => $value)
				$output[] = " $name=\"$value\"";
			$output[] = '>';
		}

		if ($this->prefix) $output[] = $this->prefix;
		return implode('', $output);
	}

	public function content() 
	{
		$output = array();
		foreach($this->children as $child)
			$output[] = $child instanceof Base ? $child->get() : $child;
		return implode($this->separator, $output);
	}

	public function close() 
	{
		$output = array();
		if ($this->suffix) $output[] = $this->suffix;
		if ($this->tag) $output[] = "</$this->tag>";
		return implode('', $output);
	}

	public function get() 
	{
		$output = array();
		$output[] = $this->open();
		$output[] = $this->content();
		$output[] = $this->close();
		return implode('', $output);
	}

	public function display() 
	{
		echo $this->get();
	}

//****************************************************************************
// UTILITIES
//****************************************************************************

	protected function sanitizeTag($tag) 
	{
		preg_match(
			'/[a-z][a-z0-9]*/', 
			strtolower(trim($tag)), 
			$matches
		);
		return count($matches) > 0
			? $matches[0]
			: '';
	}

	protected function sanitizeId($id) 
	{
		preg_match(
			'/[_a-zA-Z-]+[_a-zA-Z0-9-]*/',
			trim($id),
			$matches
		);
		return count($matches) > 0
			? $matches[0]
			: '';
	}

	protected function sanitizeClass($class) 
	{
		preg_match_all(
			'/[_a-zA-Z-]+[_a-zA-Z0-9-]*/',
			trim($class),
			$matches
		);
		return implode(' ', $matches[0]);
	}

}
