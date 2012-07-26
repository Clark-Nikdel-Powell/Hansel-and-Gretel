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

final class HAG_Breadcrumbs {
	
	public static function activate() {
		
	}
	
	public static function deactivate() {
		
	}
	
	public static function uninstall() {
		
	}
	
	public static function initialize() {
		
	}
	
	public static function display(array $args = null) {
		
	}
	
}

register_activation_hook(__FILE__, array('HAG_Breadcrumbs', 'activate'));
register_deactivation_hook(__FILE__, array('HAG_Breadcrumbs', 'deactivate'));
register_uninstall_hook(__FILE__, array('HAG_Breadcrumbs', 'uninstall'));

HAG_Breadcrumbs::initialize();

function HAG_Breadcrumbs(array $options = null) {
	
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