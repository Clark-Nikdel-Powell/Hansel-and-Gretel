<?php

/**
 * Utility functions used by the Hansel and Gretel plugin.
 * 
 * @final
 */
final class HAG_Utils {
	
	/**
	 * Sanitize a provided element to a 'valid' HTML element name.
	 * This does NOT check to see if the element is an actual HTML element,
	 * but rather an alphanumeric string not beginning with a number.
	 * 
	 * @access public
	 * @static
	 * @param string $element The element name to be sanitized
	 * @return string
	 */
	public static function sanitize_element($element) {
		preg_match(
			'/[a-z][a-z0-9]*/', 
			strtolower(trim($element)), 
			$matches
		);
		return count($matches) > 0
			? $matches[0]
			: '';
	}
	
	/**
	 * Sanitize the id added to an element.
	 * 
	 * @access public
	 * @static
	 * @param string $id The id to be sanitized
	 * @return string
	 */
	public static function sanitize_id($id) {
		preg_match(
			'/[_a-zA-Z-]+[_a-zA-Z0-9-]*/',
			trim($id),
			$matches
		);
		return count($matches) > 0
			? $matches[0]
			: '';
	}
	
	/**
	 * Sanitize a class(es) added to an element. 
	 * 
	 * @access public
	 * @static
	 * @param mixed $class The class(es) to be sanitized
	 * @return string
	 */
	public static function sanitize_class($class) {
		preg_match_all(
			'/[_a-zA-Z-]+[_a-zA-Z0-9-]*/',
			trim($class),
			$matches
		);
		return implode(' ', $matches[0]);
	}
	
	/**
	 * Coalesce the class(es) applied to the given crumb, based on whether or not 
	 * the crumb is the home page and/or the last crumb.
	 * 
	 * @access public
	 * @static
	 * @param array $options
	 * @param bool $is_home (default: false)
	 * @param bool $is_last (default: false)
	 * @return string
	 */
	public static function get_crumb_class(array $options, $is_home = false, $is_last = false) {
		$crumb_class = $options['crumb_class'];
		if ($is_home) $crumb_class .= ' '.$options['home_class'];
		if ($is_last) $crumb_class .= ' '.$options['last_class'];
		return self::sanitize_class($crumb_class);
	}
	
	/**
	 * Coalesce the id applied to the given crumb, based on whether or not the
	 * crumb is the home page or the last crumb.
	 * 
	 * @access public
	 * @static
	 * @param array $options
	 * @param bool $is_home (default: false)
	 * @param bool $is_last (default: false)
	 * @return string
	 */
	public static function get_crumb_id(array $options, $is_home = false, $is_last = false) {
		$crumb_id = '';
		if ($is_home) $crumb_id = $options['home_id'];
		if ($is_last) $crumb_id = $options['last_id'];
		return HAG_Utils::sanitize_id($crumb_id);
	}	
	
	/**
	 * Coalesce whether or not the crumb should have a link applied to it, based on
	 * whether or not the crumb is the home page or the last crumb.
	 * 
	 * @access public
	 * @static
	 * @param array $options
	 * @param bool $is_home (default: false)
	 * @param bool $is_last (default: false)
	 * @return bool
	 */
	public static function get_crumb_link(array $options, $is_home = false, $is_last = false) {
		$crumb_link = $options['crumb_link'];
		if ($is_home) $crumb_link = $options['home_link'];
		if ($is_last) $crumb_link = $options['last_link'];
		return (bool)$crumb_link;
	}
	
	/**
	 * Checks whether or not a custom front page has been specified in the Wordpress
	 * admin under Settings > Reading > Front page displays.
	 * 
	 * @access public
	 * @static
	 * @return bool
	 */
	public static function has_front_page() {
		return 'posts' !== get_option('show_on_front', 'posts')
			&& 0 < get_option('page_on_front', 0);
	}
	
	/**
	 * Checks whether or not a custom blog page has been specified in the WordPress
	 * admin under Settings > Reading > Front page displays.
	 * 
	 * @access public
	 * @static
	 * @return bool
	 */
	public static function has_blog_home() {
		return 'posts' !== get_option('show_on_front', 'posts')
			&& 0 < get_option('page_for_posts', 0);
	}

	/**
	 * Gets the post object of the custom front page if it exists. Returns null
	 * otherwise.
	 * 
	 * @access public
	 * @static
	 * @return object
	 */
	public static function get_front_page() {
		if (!self::has_front_page()) return null;
		$id = (int) get_option('page_on_front');
		return get_post($id);
	}
	
	/**
	 * Gets the post object of the custom blog home page if it exists. Returns null
	 * otherwise.
	 * 
	 * @access public
	 * @static
	 * @return object
	 */
	public static function get_blog_home() {
		if (!self::has_blog_home()) return null;
		$id = (int) get_option('page_for_posts');
		return get_post($id);
	}
	
}
