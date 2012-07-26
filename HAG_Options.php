<?php

final class HAG_Options {

	private static $defaults = array(
		'wrapper_element' => 'p',
		'wrapper_class'   => 'breadcrumbs',
		'wrapper_id'      => '',
		
		'crumb_element' => '',
		'crumb_class'   => '',
		'crumb_link'    => true,
		
		'link_class' => '',
		
		'prefix'    => '',
		'suffix'    => '',
		'separator' => '/',
		
		'home_show'  => true,
		'home_link'  => true,
		'home_label' => 'Home',
		'home_class' => '',
		'home_id'    => '',
		
		'post_type_show' => true,

		'taxonomy_show' => true,
		'taxonomy_name_show' => false,
		'taxonomy_ancestors_show' => true,
		'taxonomy_preferred' => '',
		
		'last_show'  => true,
		'last_link'  => true,
		'last_class' => '',
		'last_id'    => '',
		
		'microdata_inc' => true,
		'microdata_format' => 'schema',
		
		'post_types' => array()
	);



	
}

?>