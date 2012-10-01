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
	
	/**
	 * Gets the terms associated with a post object and filters out any excluded terms set in the options.
	 * 
	 * @access public
	 * @static
	 * @param int $post_id
	 * @param mixed $taxonomies
	 * @param array $term_args
	 * @param array $options
	 * @return array the filtered term objects
	 */
	public static function get_filtered_object_terms($post_id, $taxonomies, array $term_args, array $options) {
		$terms = wp_get_object_terms($post_id, $taxonomies, $term_args);
		$exc_taxes = $options['excluded_taxonomies'];
		$exc_terms = $options['taxonomy_excluded_terms'];
		$output = array();
		foreach ($terms as $term) {
			$tax = $term->taxonomy;
			if (is_array($exc_taxes) && in_array($tax, $exc_taxes)) continue;
			if (is_array($exc_terms) && array_key_exists($tax, $exc_terms)) {
				$exc = $exc_terms[$tax];
				if (is_array($exc) && in_array($term->slug, $exc)) continue;
				elseif ($exc === $term->slug) continue;
			}
			$output[] = $term;
		}
		return $output;
	}
	
	/**
	 * Print debug information regarding the current state of the page to the screen.
	 * 
	 * @access public
	 * @static
	 * @param array $options
	 * @param bool $comment (default: false)
	 * @return void
	 */
	public static function debug_info(array $options, $comment = false) {
		global $post;
		
		$output = array();
		$output[] = $comment ? '<!--' : '<pre>';

		$output[] = '######################## HaG DEBUG INFO ########################';
		
		$output[] = sprintf('404: %b', is_404());
		$output[] = sprintf('Search: %b', is_search());
		$output[] = sprintf('Archive: %b', is_archive());
		$output[] = sprintf('Custom Taxonomy Archive: %b', is_tax());
		$output[] = sprintf('Category Archive: %b', is_category());
		$output[] = sprintf('Tag Archive: %b', is_tag());
		$output[] = sprintf('Author Archive: %b', is_author());
		$output[] = sprintf('Date Archive: %b', is_date());
		$output[] = sprintf('Year Archive: %b', is_year());
		$output[] = sprintf('Month Archive: %b', is_month());
		$output[] = sprintf('Day Archive: %b', is_day());
		$output[] = sprintf('Custom Post-Type Archive: %b', is_post_type_archive());
		$output[] = sprintf('Paged: %b', is_paged());
		$output[] = sprintf('Singular Page: %b', is_singular());
		$output[] = sprintf('Single Post Page: %b', is_single());
		$output[] = sprintf('Attachment Post: %b', is_attachment());
		$output[] = sprintf('Static Page: %b', is_page());
		$output[] = sprintf('Custom Static Page: %b', is_page_template());
		$output[] = sprintf('Site Front Page: %b', is_front_page());
		$output[] = sprintf('Posts Home Page: %b', is_home());
		$output[] = sprintf('Comments Popup Page: %b', is_comments_popup());

		$output[] = '######################## QUERY ############################';
		ob_start();
		var_dump(get_queried_object());
		$output[] = $comment ? ob_get_clean() : htmlentities(ob_get_clean());

		$output[] = '######################## $POST ########################';
		ob_start();
		var_dump($post);
		$output[] = $comment ? ob_get_clean() : htmlentities(ob_get_clean());
		
		$output[] = '######################## $OPTIONS ########################';
		ob_start();
		var_dump($options);
		$output[] = $comment ? ob_get_clean() : htmlentities(ob_get_clean());
		
		$output[] = $comment ? '-->' : '</pre>';
		
		echo implode(PHP_EOL, $output);
	}
	
}
