<?php

/**
 * Options controller for safely setting and getting all the custom settings
 * available to the Hansel & Gretel plugin
 * 
 * @final
 */
final class HAG_Options {

	/**
	 * The name of the WordPress option used with add_option(), get_option(),
	 * update_option() and delete_option()
	 */
	const option_name = 'HAG_Options';

	/**
	 * The default settings for the Hansel & Gretel plugin. These defaults are
	 * trumped by settings saved to the database via the admin settings page for
	 * the plugin, which is trumped in turn by any settings applied to the
	 * specified post type, and is lastly overridden by any settings applied at
	 * the calling of the plugin within the template file.
	 * 
	 * @var array
	 * @access private
	 * @static
	 */
	private static $defaults = array(
		
		/**
		 * Whether or not debug information should be printed to the output.
		 */
		'debug_show' => false,
		
		/**
		 * Whether or not the debug information should be printed in a comment.
		 * Otherwise, the debug information will be output in a <pre> element.
		 */
		'debug_comment' => true,
		
		/**
		 * The HTML element that wraps the entire breadcrumbs list.
		 */
		'wrapper_element' => 'p',
		
		/**
		 * The class applied to the wrapper element.
		 * May be left blank for no class to be added.
		 */
		'wrapper_class' => '',
		
		/**
		 * The id applied to the wrapper element.
		 * May be left blank for no id to be added.
		 */
		'wrapper_id' => 'breadcrumbs',
		
		/**
		 * The HTML element that wraps each breadcrumb.
		 * May be left blank for no element to be applied.
		 */
		'crumb_element' => '',
		
		/**
		 * The class applied to the crumb element if it exists.
		 * May be left blank for no class to be added.
		 */
		'crumb_class' => '',
		
		/**
		 * Whether or not the crumb should link to its associated
		 * page in the hierarchy.
		 */
		'crumb_link' => true,
		
		/**
		 * The class applied to the crumb link.
		 * May be left blank for no class to be added.
		 */
		'link_class' => '',
		
		/**
		 * The content and/or markup to be added immediately after
		 * the opening of the breadcrumbs wrapper. May be left blank
		 * for no content to be added.
		 */
		'prefix' => '',
		
		/**
		 * The content and/or markup to be added immediately before
		 * the closing of the breadcrumbs wrapper. May be left blank
		 * for no content to be added.
		 */
		'suffix' => '',
		
		/**
		 * The content and/or markup to be added between crumbs. The
		 * separator is padded on both sides by a single space. May be
		 * left blank for no separator to be added.
		 */
		'separator' => '&raquo;',
		
		/**
		 * Whether or not a root crumb for the site home should be shown.
		 */
		'home_show' => true,
		
		/**
		 * Whether or not the root crumb should be linked to the site home.
		 */
		'home_link' => true,
		
		/**
		 * The label for the root crumb if it is included in the breadcrumbs.
		 */
		'home_label' => 'Home',
		
		/**
		 * The class applied to the root crumb if it is included.
		 * May be left blank for no class to be added.
		 */
		'home_class' => '',
		
		/**
		 * The id applied to the root crumb if it is included.
		 * May be left blank for no id to be added.
		 */
		'home_id' => '',
		
		/**
		 * The label for the 404 crumb if last_show is true.
		 */
		'404_label' => 'Page Not Found',
		
		/**
		 * The label for search results pages if last_show is true.
		 */
		'search_label' => 'Search Results',
		
		/**
		 * Whether or not to include the search term as a crumb if last_show is true.
		 */
		'search_query' => false,
		
		/**
		 * Whether or not a crumb should be included for the post type
		 * of the current location. Will only be applicable on post types
		 * where an archive exists.
		 */
		'post_type_show' => true,
		
		/**
		 * Whether or not to show the ancestors of a hierarchical taxonomy if a
		 * child term is assigned. Will only be applicable on posts that have
		 * assigned hierarchical taxonomies.
		 *
		 */
		'taxonomy_ancestors_show' => true,
		
		/**
		 * By default, the breadcrumbs will choose the most popular taxonomy
		 * associated with the post if multiple are assigned. Choosing a preferred
		 * taxonomy will attempt to choose the assigned taxonomy before falling back
		 * to the default method. Will only be applicable on posts that have
		 * assigned hierarchical taxonomies.
		 *
		 */ 
		'taxonomy_preferred' => '',
		
		/**
		 * Whether or not to show the last crumb (the current location) in the
		 * breadcrumbs.
		 */
		'last_show' => true,
		
		/**
		 * Whether or not the last crumb (the current location) is linked.
		 */
		'last_link' => false,
		
		/**
		 * The class applied to the last crumb if it is shown.
		 * May be left blank for no class to be added.
		 */
		'last_class' => 'current',
		
		/**
		 * The id applied to the last crumb if it is shown.
		 * May be left blank for no id to be added.
		 */
		'last_id' => '',
		
		/**
		 * Whether or not to include microdata on the breadcrumbs.
		 */
		'microdata' => true,
		
		/**
		 * An associative array of {post-type} => array() including the same
		 * setting names as the root options array as overrides for the keyed
		 * post type. These post-type-specific settings override any defined
		 * defaults for the breadcrumbs.
		 */
		'post_types' => array()
	);

	/**
	 * Saves the default settings for the site into the database. These settings
	 * override the default settings defined in this class but are trumped by the
	 * post-type-specific and function call options.
	 * 
	 * @access public
	 * @static
	 * @param array $options (default: null) The options to save to the database
	 * @return void
	 */
	public static function set_defaults(array $options = null)
	{
		if (!is_array($options)) $options = array();
		$options = wp_parse_args($options, self::$defaults);
		update_option(self::option_name, $options);
	}
	
	/**
	 * Gets the default options for the plugin. if $include_options is set to
	 * false, the defaults saved to the database will be ignored and only the
	 * settings defined in this class will be returned.
	 * 
	 * @access public
	 * @static
	 * @param bool $include_options (default: true) Whether or not to include the saved options
	 * @return void
	 */
	public static function get_defaults($include_options = true) {
		if (!$include_options) return self::$defaults;
		$options = get_option(self::option_name, array());
		return wp_parse_args($options, self::$defaults);
	}
		
	/**
	 * Resolves the options at the function call with the default functions of the
	 * plugin. Optionally, if the $post_type is specified, the options will be further
	 * resolved to include the overrides for the post type if custom settings exist.
	 * 
	 * @access public
	 * @static
	 * @param array $options (default: null) Options set at the function call
	 * @param string $post_type (default: '') The post type to also resolve
	 * @return void
	 */
	public static function get_options(array $options = null, $post_type = '')
	{
		if (!is_array($options)) $options = array();
		if (!is_string($post_type)) $post_type = '';
		$defaults = self::get_defaults();
		
		if ('' === $post_type) 
			return wp_parse_args($options, $defaults);
		
		$pt_key = 'post_types';

		$pt_options = array();
		if (is_array($defaults[$pt_key])
			&& array_key_exists($post_type, $defaults[$pt_key])
			&& is_array($defaults[$pt_key][$post_type]))
			$pt_options = $defaults[$pt_key][$post_type];
			
		$fpt_options = array();	
		if (array_key_exists($pt_key, $options)
			&& is_array($options[$pt_key])
			&& array_key_exists($post_type, $defaults[$pt_key])
			&& is_array($options[$pt_key][$post_type]))
			$fpt_options = $options[$pt_key][$post_type];

		$output = wp_parse_args($pt_options, $defaults);
		$output = wp_parse_args($options, $output);
		$output = wp_parse_args($fpt_options, $output);
		return $output;
	}

}
