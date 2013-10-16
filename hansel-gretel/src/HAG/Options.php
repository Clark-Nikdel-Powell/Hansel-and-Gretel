<?php
namespace HAG;

/**
 * Options controller for safely setting and getting all the custom settings 
 * available to the Hansel & Gretel plugin
 */
final class Options {

	/**
	 * The name of the WordPress option used with add_option(), get_option(),
	 * update_option() and delete_option()
	 * 
	 * @var string
	 */
	protected $optionName = 'HAG_Options';

	/**
	 * The parsed option values
	 * @var array
	 */
	protected $values = array();

	/**
	 * The default settings for the Hansel & Gretel plugin. These defaults are
	 * trumped by settings saved to the database via the admin settings page for
	 * the plugin, which are trumped in turn by any settings applied to the
	 * specified post type, and are lastly overridden by any settings applied at
	 * the calling of the plugin within the template file.
	 * 
	 * @var array
	 */
	protected $defaultValues = array(
		
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
		 * Whether or not taxonomy breadcrumbs should be included for the current
		 * location. This is only applicable on single, non-archive pages for
		 * non-hierarchical post types (eg, posts).
		 */
		'taxonomy_show' => true,
		
		/**
		 * Whether or not to show the ancestors of a hierarchical taxonomy if a
		 * child term is assigned. Will only be applicable on posts that have
		 * assigned hierarchical taxonomies.
		 */
		'taxonomy_ancestors_show' => true,
		
		/**
		 * By default, the breadcrumbs will choose the most popular taxonomy
		 * associated with the post if multiple are assigned. Choosing a preferred
		 * taxonomy will attempt to choose the assigned taxonomy before falling back
		 * to the default method. Will only be applicable on posts that have
		 * assigned taxonomies.
		 */ 
		'taxonomy_preferred' => '',
		
		/**
		 * An array of taxonomies that should be excluded from the breadcrumbs. Will
		 * only be applicable on non-archive posts that have assigned taxonomies.
		 */
		'excluded_taxonomies' => array(),
		
		/**
		 * An associative array of {taxonomy} => array() including the term slugs of
		 * that taxonomy that should not be included in the breadcrumbs (except on a
		 * taxonomy archive page)
		 */
		'taxonomy_excluded_terms' => array(),
		
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

	/****************************************************************************
	 * CONSTRUCTION
	 ****************************************************************************/

	/**
	 * Creates a Options instance to be used when generating the crumbs
	 * @param array $args Options to apply over the saved defaults
	 */
	public function __construct(array $args = null)
	{
		$this->values = apply_filters('hag_options', $this->parseValues($args));
	}

	/**
	 * Combines the defaults, stored db values, and passed values into an
	 * associative array contain all expected option values.
	 * @param  array $args Options to apply over the saved defaults
	 * @return array       All possible option values
	 */
	protected function parseValues(array $args = null)
	{
		$output = wp_parse_args($this->getDbValues(), $this->defaultValues);
		$output = wp_parse_args($args, $output);
		return $output;
	}

	/****************************************************************************
	 * ACCESSORS
	 ****************************************************************************/

	/**
	 * Gets the value of a particular option with a potential post type override
	 * @param  string $name      Name of the option to return
	 * @param  string $post_type Optional name of post type to override settings with
	 * @return mixed
	 */
	public function get($name, $post_type = false)
	{
		if (!isset($this->values[$name])) {
			trigger_error("Could not find option '$name'.");
			return false;
		}

		$value = $this->values[$name];

		if ($post_type && isset($this->values['post_types'][$post_type])) {
			$pt = $this->values['post_types'][$post_type];
			if (is_array($pt) && isset($pt[$name]))
				$value = $pt[$name];
		}

		return apply_filters('hag_option', $value, $name, $post_type);
	}

	public function set($name, $value)
	{
		$this->values[$name] = $value;
	}

	public function setAll($values)
	{
		foreach($values as $name => $value)
			$this->values[$name] = $value;
	}

	public function clear($name)
	{
		if (isset($this->values[$name])) 
			unset($this->values[$name]);

		if (isset($this->defaultValues[$name])) 
			$this->values[$name] = $this->defaultValues[$name];
	}

	public function clearAll()
	{
		$this->values = $thid->defaultValues;
	}

	/****************************************************************************
	 * DATABASE LIFECYCLE
	 ****************************************************************************/

	protected function getDbValues()
	{
		return get_option($this->optionName, array());
	}

	protected function addDbValues()
	{
		return add_option($this->optionName, $this->values);
	}

	protected function updateDbValues()
	{
		return update_option($this->optionName, $this->values);
	}

	protected function deleteDbValues()
	{
		return delete_option($this->optionName);
	}

	/****************************************************************************
	 * RAW OUTPUTS
	 ****************************************************************************/

	public function databaseRaw()
	{
		return $this->getDbValues();
	}

	public function defaultsRaw()
	{
		return $this->defaultValues;
	}

	public function raw()
	{
		return $this->values;
	}

}
