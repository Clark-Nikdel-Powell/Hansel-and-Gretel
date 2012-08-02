<? 
/*
Plugin Name: Hansel & Gretel
Plugin URI: https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel
Description: Adds fine-tuned breadcrumb generation to your Wordpress Site, including custom structure, markup, and microdata.
Author: Chris Roche & Taylor Gorman [Clark Nikdel Powell]
Author URI: http://clarknikdelpowell.com/
Version: 0.0.3
License: GPL2

Copyright 2012  Clark Nikdel Powell  (email : wordpress@clarknikdelpowell.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once plugin_dir_path(__FILE__).'HAG_Options.php';
require_once plugin_dir_path(__FILE__).'HAG_Wrapper.php';
require_once plugin_dir_path(__FILE__).'HAG_Crumb.php';

/**
 * Wrapper around the breadcrumb functionality and WordPress administrative
 * hooks.
 * 
 * @final
 */
final class HAG_Breadcrumbs {
	
	/**
	 * Private constructor...you don't need an instance.
	 * 
	 * @access private
	 * @return void
	 */
	private function __construct() { }
	
	/**
	 * Private cloning function...you don't need an instance.
	 * 
	 * @access private
	 * @return void
	 */
	private function __clone() { }	
	
	/**
	 * Hook function for when the plugin is activated. Adds the default
	 * options to the database.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function activate() {
		add_option(HAG_Options::option_name, array(), '', 'yes');
	}
	
	/**
	 * Hook function for when the plugin is deleted. Removes the default
	 * options from the database.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function uninstall() {
		delete_option(HAG_Options::option_name);
	}
	
	/**
	 * Initialize the plugin. This will register the admin options page
	 * for the plugin.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function initialize() {
		//!TODO: Create Admin menu item
	}

	/**
	 * Outputs the breadcrumbs based on the specified options (resolved
	 * against the saved and plugin defaults).
	 * 
	 * @access public
	 * @static
	 * @param array $options (default: null)
	 * @return void
	 */
	public static function display(array $options = null) {
		
		/******************************************************** RESOLVE POST TYPE */
		$post = get_queried_object();
		$post_type = '';
		if (is_single()) $post_type = $post->post_type;
		elseif (is_post_type_archive()) $post_type = $post->name;
				
		/***************************** LOAD AND RESOLVE OPTIONS FOR THE BREADCRUMBS */
		if (!is_array($options)) $options = array();
		$options = HAG_Options::get_options($options, $post_type);
		
		/*************************************** PRINT DEBUG INFORMATION IF DESIRED */
		if ($options['debug_show']) 
			HAG_Utils::debug_info($options, $options['debug_comment']);
		
		/************************************* OBTAIN CRUMBS AND EXIT IF NONE FOUND */
		$crumbs = HAG_Crumb::get_crumbs($options);
		if (0 === count($crumbs)) return;
		
		/********************************************* BUILD OUTPUT BASED ON OPTIONS*/
		$wrapper = new HAG_Wrapper($options);
		
		$output = array();
		$output[] = $wrapper->display(true);
		$output[] = implode(
			sprintf(' %s ', $options['separator']), 
			$crumbs
		);
		$output[] = $wrapper->display(false);
		
		echo implode('', $output);
	}
	
}

/**
 * Convenience function to call HAG_Breadcrumbs::display(). Outputs the
 * breadcrumbs based on the specified options (resolved against the saved
 * and plugin defaults).
 * 
 * @access public
 * @param array $options (default: null)
 * @return void
 */
function HAG_Breadcrumbs(array $options = null) {
	HAG_Breadcrumbs::display($options);
}

// WordPress Admin Mumbo Jumbo
register_activation_hook(__FILE__, array('HAG_Breadcrumbs', 'activate'));
register_uninstall_hook(__FILE__, array('HAG_Breadcrumbs', 'uninstall'));
HAG_Breadcrumbs::initialize();
