<?
/*
Plugin Name: Hansel & Gretel
Plugin URI: http://rodaine.com/wordpress/hansel-and-gretel
Description: Adds fine-tuned breadcrumb generation to your Wordpress Site, including custom structure, markup, and microdata.
Author: Chris Roche & Taylor Gorman [Clark Nikdel Powell]
Author URI: http://clarknikdelpowell.com/
Version: 0.0.1
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

final class HAG_Breadcrumbs {
	
	//////////////////////////////////////WORDPRESS PLUGIN ADMINISTRATIVE FUNCTIONS
	
	public static function activate() {
		add_option(HAG_Options::option_name, array(), '', 'yes');
	}
	
	public static function uninstall() {
		delete_option(HAG_Options::option_name);
	}
	
	public static function initialize() {
		//!TODO: Create Admin menu item
	}
	
	
	
	//////
	
	private static function debug_info(array $options = null, $comment = false) {
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
	
	private static function get_crumbs($options) {
		global $post;
		//!TODO: Build items
		return array('Home', 'Tree');
	}
	
	public static function display(array $options = null) {
		
		/***************************** LOAD AND RESOLVE OPTIONS FOR THE BREADCRUMBS */
		if (!is_array($options)) $options = array();
		$options = HAG_Options::get_options($options);
		
		
		/*************************************** PRINT DEBUG INFORMATION IF DESIRED */
		/*if ($options['debug_show'])*/ self::debug_info($options);
		
		
		/************************************* OBTAIN CRUMBS AND EXIT IF NONE FOUND */
		$crumbs = self::get_crumbs($options);
		if (0 === count($crumbs)) return;
		
		
		/********************************************* BUILD OUTPUT BASED ON OPTIONS*/
		$output = array();
	
		$has_wrapper = !empty($options['wrapper_element'])
	
	
		//add prefix
		if (!empty($options['prefix'])) $output[] = $options['prefix'];
				
		$output[] = implode(
			sprintf(' %s ', $options['separator']),
			$crumbs
		);
		
		//add suffix
		if (!empty($options['prefix'])) $output[] = $options['suffix'];
		
		echo implode(PHP_EOL, $output);
	}
	
}

register_activation_hook(__FILE__, array('HAG_Breadcrumbs', 'activate'));
register_uninstall_hook(__FILE__, array('HAG_Breadcrumbs', 'uninstall'));

HAG_Breadcrumbs::initialize();

function HAG_Breadcrumbs(array $options = null) {
	HAG_Breadcrumbs::display($options);
}

/*
function breadcrumbs($args=0) {
	
	$defaults = array(
		'before' => '<p>'
	,	'after'  => '</p>'
	,	'between' => ' &raquo; '
	,	'showhome' => true
	,	'showcurrent' => true
	,	'linkcurrent' => false
	//,	'posttypetax' => array('project'=>'industry', 'update'=>'project')
	//,	'posttypetitle' => array('project'=>true, 'update'=>false)
	);
	$vars = wp_parse_args($args, $defaults);
	$links = array();
	
	// Home link
	if ($vars['showhome']) { $links[] = '<a href="/">Home</a>'; }
	
	// Between links
	global $post;
	$hier = is_post_type_hierarchical($post->post_type);
	if ($hier) : // Hierarchical post types (like pages)
		
		$parent_id = $post->post_parent;
		while ($parent_id) :
			$parent = get_post($parent_id);
			$links[] = '<a href="'.$parent->guid.'">'.$parent->post_title.'</a>';
			$parent_id = $parent->post_parent;
		endwhile;
		
	else : // Non-hierarchical post types (like posts)
		
		//home > post type > taxonomy > post title
		
	endif;
	
	// Current page link
	if ($vars['showcurrent']) :
		if ($vars['linkcurrent']) :
			$linkbefore = '<a href="'.$post->guid.'">';
			$linkafter = '</a>';
		endif;
		$links[] = $linkbefore.$post->post_title.$linkafter;
	endif;
	
	//print '<pre>'; var_dump($hier); print '</pre>';
	//print '<pre>'.print_r($post,true).'</pre>';
	
	// Print breadcrumbs
	if ($links) :
		print $vars['before'];
		$lastlink = end($links);
		foreach($links as $link) :
			print $link.($link == $lastlink ? '' : $vars['between']);
		endforeach;
		print $vars['after'];
	endif;
	
} // function breadcrumbs
*/
?>