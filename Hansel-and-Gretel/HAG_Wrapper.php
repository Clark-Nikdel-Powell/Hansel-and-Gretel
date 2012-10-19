<?php

require_once plugin_dir_path(__FILE__).'HAG_Utils.php';

/**
 * Generates the breadcrumbs wrapper element including prefix and suffix content.
 * 
 * @final
 */
final class HAG_Wrapper {
	
	/**
	 * The options applied to this breadcrumb wrapper
	 * 
	 * @var array
	 * @access private
	 */
	private $options;
	
	/**
	 * Creates an instance of HAG_Wrapper with the specified options.
	 * 
	 * @access public
	 * @param array $options
	 * @return void
	 */
	public function __construct(array $options) {
		$this->options = $options;
	}
	
	/**
	 * Read-Only Access to properties of HAG_Wrapper.
	 * 
	 * @access public
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->$name;
	}
	
	/**
	 * Returns the wrapper element if it exists including specified id, class, 
	 * microdata, prefix and suffix.
	 * 
	 * @access public
	 * @param bool $open_tag (default: true) Whether or not to output the opening or closing tag
	 * @return string
	 */
	public function display($open_tag = true) {
		$element = HAG_Utils::sanitize_element($this->options['wrapper_element']);
		
		if (empty($element) && $open_tag) return $this->options['prefix'];
		if (empty($element) && !$open_tag) return $this->options['suffix'];
		if (!$open_tag) return sprintf('%s</%s>', $this->options['suffix'], $element);
		
		$class = HAG_Utils::sanitize_class($this->options['wrapper_class']);
		$id = HAG_Utils::sanitize_class($this->options['wrapper_id']);
		
		$wrapper = array();
		$wrapper[] = sprintf('<%s', $element);
		
		if (!empty($id)) $wrapper[] = sprintf('id="%s"', $id);
		if (!empty($class)) $wrapper[] = sprintf('class="%s"', $class);
		if ($this->options['microdata']) $wrapper[] = 'itemprop="breadcrumb"';
		
		$wrapper[] = sprintf('>%s', $this->options['prefix']);
			
		return implode(' ', $wrapper);
	}
		
}
