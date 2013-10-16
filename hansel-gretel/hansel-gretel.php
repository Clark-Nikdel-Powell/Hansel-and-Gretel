<?php 
/*
Plugin Name: Hansel & Gretel
Plugin URI: https://github.com/Clark-Nikdel-Powell/Hansel-and-Gretel
Description: Adds fine-tuned breadcrumb generation to your Wordpress Site, including custom structure, markup, and microdata.
Author: Chris Roche & Taylor Gorman [Clark Nikdel Powell]
Author URI: http://clarknikdelpowell.com/
Version: 1.0.0
License: GPL3

Copyright 2012-2013 Clark Nikdel Powell (email : wordpress@clarknikdelpowell.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

require 'vendor/autoload.php';

function HAG_Breadcrumbs(array $options = array(), WP_Query $context = null) {

	//ensure context is available
	global $wp_query;
	if (is_null($context)) $context = $wp_query;

	//get the options object
	$options = new \HAG\Options($options);

	//handle debug info if required
	if ($options->get('debug_show')) {
		$debug = new \HAG\Debug($options, $context);
		$debug->display();
	}
	
	//show the trail
	$trail = new \HAG\Trail($options, $context);
	$trail->display();
}

