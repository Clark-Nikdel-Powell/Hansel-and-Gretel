<?

/*

TYPICAL WORDPRESS PLUGIN JARGON WILL NEED TO GO HERE

*/

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

?>