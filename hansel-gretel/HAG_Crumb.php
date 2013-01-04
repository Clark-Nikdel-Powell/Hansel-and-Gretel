<?php

require_once plugin_dir_path(__FILE__).'HAG_Utils.php';

/**
 * Describes a single crumb in the breadcrumbs chain.
 * 
 * @final
 */
final class HAG_Crumb {
	
	/**
	 * The options applied to this crumb.
	 * 
	 * @var array
	 * @access private
	 */
	private $options;
	
	/**
	 * The label for this crumb.
	 * 
	 * @var string
	 * @access private
	 */
	private $label;
	
	/**
	 * The link url for this crumb.
	 * 
	 * @var string
	 * @access private
	 */
	private $url;
	
	/**
	 * Whether or not this crumb is a home crumb.
	 * 
	 * @var bool
	 * @access private
	 */
	private $is_home;
	
	/**
	 * Whether or not this crumb is the last (current) crumb.
	 * 
	 * @var bool
	 * @access private
	 */
	private $is_last;
	
	/**
	 * Creates an instance of a crumb.
	 * 
	 * @access private
	 * @param array $options
	 * @param string $label
	 * @param string $url (default: '')
	 * @param bool $is_home (default: false)
	 * @param bool $is_last (default: false)
	 * @return HAG_Crumb
	 */
	private function __construct(array $options, $label, $url = '', $is_home = false, $is_last = false) {
		$this->options = $options;
		$this->label = trim($label);
		$this->url = trim($url);
		$this->is_home = (bool)$is_home;
		$this->is_last = (bool)$is_last;
	}
	
	/**
	 * Read-Only Access to Crumb properties.
	 * 
	 * @access public
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) { return $this->$name; }
	
	///////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////ELEMENT, LINK, CLASS & ID UTILITIES
	///////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Gets the crumb's wrapper element name.
	 * 
	 * @access private
	 * @return string
	 */
	private function get_element() {
		return HAG_Utils::sanitize_element($this->options['crumb_element']);
	}

	/**
	 * Gets the crumb's id.
	 * 
	 * @access private
	 * @return string
	 */
	private function get_id() {
		$id = '';
		if ($this->is_home) $id = $this->options['home_id'];
		if ($this->is_last) $id = $this->options['last_id'];
		return HAG_Utils::sanitize_id($id);
	}	
	
	/**
	 * Gets the crumb's class(es).
	 * 
	 * @access private
	 * @return string
	 */
	private function get_class() {
		$class = array();
		$class[] = $this->options['crumb_class'];
		if ($this->is_home) $class[] = $this->options['home_class'];
		if ($this->is_last) $class[] = $this->options['last_class'];
		return HAG_Utils::sanitize_class(implode(' ', $class));
	}

	/**
	 * Whether or not the crumb should be linked.
	 * 
	 * @access private
	 * @return bool
	 */
	private function has_link() {
		$link = $this->options['crumb_link'];
		if ($this->is_home) $link = $this->options['home_link'];
		if ($this->is_last) $link = $this->options['last_link'];
		return (bool)$link;
	}
	
	///////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////STRING GENERATION
	///////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Gets the crumb's wrapper if it exists.
	 * 
	 * @access private
	 * @param bool $open_tag (default: true) Whether or not to return the open or close tag
	 * @return string
	 */
	private function get_wrapper($open_tag = true) {
		$element = $this->get_element();
		
		if (empty($element)) return '';
		if (!$open_tag) return sprintf('</%s>', $element);
		
		$class = $this->get_class();
		$id = $this->get_id();
		
		$wrapper = array();
		$wrapper[] = sprintf('<%s', $element);
		
		if (!empty($id)) $wrapper[] = sprintf('id="%s"', $id);
		if (!empty($class)) $wrapper[] = sprintf('class="%s"', $class);
		
		$wrapper[] = '>';
		
		return implode(' ', $wrapper);
	}
	
	/**
	 * Gets the crumb's link if it exists.
	 * 
	 * @access private
	 * @param bool $open_tag (default: true) Whether or not to return the open or close tag
	 * @return string
	 */
	private function get_link($open_tag = true) {
		$link = $this->has_link();
		
		if (!$link || empty($this->url)) return '';
		if (!$open_tag) return '</a>';
		
		$element = $this->get_element();
		$class = HAG_Utils::sanitize_class($this->get_class().' '.$this->options['link_class']);
		$id = $this->get_id();
		
		$link = array();
		$link[] = sprintf('<a href="%s"', $this->url);
		
		if (empty($element) && !empty($id))
			$link[] = sprintf('id="%s"', $id);
			
		if (empty($element) && !empty($class))
			$link[] = sprintf('class="%s"', $class);
			
		$link[] = '>';
		
		return implode(' ', $link);
	}
	
	/**
	 * Builds the crumb html markup when converted to string.
	 * 
	 * @access public
	 * @return string
	 */
	public function __toString() {
		$output = array();
		$output[] = $this->get_wrapper(true);
		$output[] = $this->get_link(true);
		$output[] = trim($this->label);
		$output[] = $this->get_link(false);
		$output[] = $this->get_wrapper(false);
		return implode('', $output);	
	}
	
	///////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////CRUMB PROCURMENT
	///////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Gets all the crumbs for the current page. Uses the template hierarchy and the
	 * provided options to determine which crumbs to return.
	 * 
	 * @access public
	 * @static
	 * @param array $options
	 * @return array
	 */
	public static function get_crumbs(array $options) {
		
		$crumbs = self::get_home_crumbs($options);

		if (is_front_page() || is_home())
			return $crumbs;
		
		elseif (is_404()) 
			return array_merge($crumbs, self::get_404_crumbs($options));
			
		elseif (is_search())
			return array_merge($crumbs, self::get_search_crumbs($options));
			
		elseif (is_date())
			return array_merge($crumbs, self::get_date_archive_crumbs($options));

		elseif (is_author())
			return array_merge($crumbs, self::get_author_crumbs($options));

		elseif (is_post_type_archive())
			return array_merge($crumbs, self::get_post_type_crumbs($options));
				
		elseif (is_category() || is_tag() || is_tax())
			return array_merge($crumbs, self::get_taxonomy_crumbs($options));	

		elseif (is_comments_popup())
			return array_merge($crumbs, self::get_comment_popup_crumbs($options));
		
		elseif (is_attachment())
			return $crumbs;

		elseif (is_singular())
			return array_merge($crumbs, self::get_singular_crumbs($options));
		
		else
			return $crumbs;
	}
	
	/**
	 * Gets the home/front-page crumbs. These are dependent on whether or not custom
	 * front-page and blog home-page templates are specified in the Wordpress Admin
	 * under Settings > Reading > Front page displays.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_home_crumbs(array $options) {
		global $post;
		$crumbs = array();
		if (!$options['home_show']) return $crumbs;

		$fp = is_front_page();
		$bh = is_home();
		$cfp = HAG_Utils::has_front_page();
		$cbh = HAG_Utils::has_blog_home();
	
		//probably a contradiction
		if ($fp && $bh && $cbh) { 
			$blog = HAG_Utils::get_blog_home();
			return array(new HAG_Crumb(
				$options,
				$blog->post_title,
				get_permalink($blog->ID),
				true,
				true
			));
		}

		//use custom front page or fall back to the settings
		if ($cfp) { 
			$front = HAG_Utils::get_front_page();
			$crumbs[] = new HAG_Crumb(
				$options,
				$front->post_title,
				site_url(),
				true,
				$fp
			);
		} else {
			$crumbs[] = new HAG_Crumb(
				$options,
				$options['home_label'],
				site_url(),
				true,
				$fp || ($bh && !$cbh)
			);	
		}

		//break out if we aren't looking deeper
		if ($fp || !$cbh) return $crumbs;
		if (!$bh && !is_null($post) && 'post' !== $post->post_type) return $crumbs;
		if (is_search() || is_404()) return $crumbs;

		//load in the custom blog page crumb
		$blog = HAG_Utils::get_blog_home();
		$crumbs[] = new HAG_Crumb(
			$options,
			$blog->post_title,
			get_permalink($blog->ID),
			false,
			$bh
		);
		
		return $crumbs;
	}
	
	/**
	 * Gets the 404 Page Not Found crumb.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_404_crumbs(array $options) {
	
		$crumbs = array();
			
		if ($options['last_show'])
			$crumbs[] = new HAG_Crumb(
				$options,
				$options['404_label'],
				'',
				false,
				true
			);
			
		return $crumbs;
	}
	
	/**
	 * Gets the Search Query crumb.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_search_crumbs(array $options) {
		$crumbs = array();
		if (!$options['last_show']) return $crumbs;

		$crumbs[] = new HAG_Crumb(
			$options,
			$options['search_label'],
			'',
			false,
			!$options['search_query']
		);
		
		if (!$options['search_query']) return $crumbs;
	
		$crumbs[] = new HAG_Crumb(
			$options,
			get_search_query(),
			'',
			false,
			true
		);

		return $crumbs;
	}
		
	/**
	 * Gets the crumbs for a date-based archive.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_date_archive_crumbs(array $options) {
		$crumbs = array();
		$date = new DateTime(get_the_date());
		$last_show = $options['last_show'];
		
		if (is_year() && !$last_show) return $crumbs;
		
		$crumbs[] = new HAG_Crumb(
			$options,
			$date->format('Y'),
			get_year_link($date->format('Y')),
			false,
			is_year()
		);
		
		if (is_year() || (is_month() && !$last_show)) return $crumbs;
		
		$crumbs[] = new HAG_Crumb(
			$options,
			$date->format('F'),
			get_month_link($date->format('Y'), $date->format('n')),
			false,
			is_month()
		);
		
		if (is_month() || (is_day() && !$last_show)) return $crumbs;
		
		$crumbs[] = new HAG_Crumb(
			$options,
			$date->format('jS'),
			get_day_link($date->format('Y'), $date->format('n'), $date->format('j')),
			false,
			is_day()
		);
		
		return $crumbs;
	}

	/**
	 * Gets the crumbs for an author-based archive.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_author_crumbs(array $options) {
		$crumbs = array();
		if (!$options['last_show']) return $crumbs;
		
		$author = get_queried_object();
		if (is_null($author) || is_wp_error($author)) return $crumbs;
		
		$crumbs[] = new HAG_Crumb(
			$options,
			$author->display_name,
			get_author_posts_url($author->ID),
			false,
			true
		);
		
		return $crumbs;
	}
	
	/**
	 * Gets the crumbs for a post-type archive.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_post_type_crumbs(array $options) {
		$crumbs = array();
		if (!$options['last_show'] || !$options['post_type_show']) return $crumbs;
			
		$pt = get_queried_object();
		if (is_null($pt) || is_wp_error($pt) || !$pt->has_archive) return $crumbs;
		
		$crumbs[] = new HAG_Crumb(
			$options,
			$pt->label,
			get_post_type_archive_link($pt->name),
			false,
			true
		);

		return $crumbs;
	}
	
	/**
	 * Gets the crumbs for a taxonomy archive.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_taxonomy_crumbs(array $options) {
		$crumbs = array();
		
		$term = get_queried_object();
		if (is_null($term) || is_wp_error($term)) return $crumbs;
		
		$tax = get_taxonomy($term->taxonomy);
		if (is_null($tax) || is_wp_error($tax)) return $crumbs;
		
		$pt = get_post_type_object($tax->object_type[0]);
		
		//add post type crumb if this taxonomy is exclusive to it
		if (1 === count($tax->object_type) 
			&& !is_null($pt) 
			&& !is_wp_error($pt) 
			&& $pt->has_archive
			&& $options['post_type_show']
		) {
			$crumbs[] = new HAG_Crumb(
				$options,
				$pt->label,
				get_post_type_archive_link($pt->name),
				false,
				false
			);
		}
		
		$rev_crumbs = array();
		
		if ($options['last_show']) {
			$rev_crumbs[] = new HAG_Crumb(
				$options,
				$term->name,
				get_term_link($term),
				false,
				true
			);
		}
		
		if ($tax->hierarchical && $options['taxonomy_ancestors_show']) {
			$term = get_term($term->parent, $term->taxonomy);
			while (!is_wp_error($term)) {
				$rev_crumbs[] = new HAG_Crumb(
					$options,
					$term->name,
					get_term_link($term),
					false,
					false
				);
				$term = get_term($term->parent, $term->taxonomy);
			}
		}
		
		return array_merge($crumbs, array_reverse($rev_crumbs));
	}
	
	/**
	 * Gets the crumbs for a comment popup page. Pulls in the same
	 * breadcrumbs that would be applied to the single page the
	 * comments popup is for.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_comment_popup_crumbs(array $options) {
		return self::get_singular_crumbs($options);
	}
	
	/**
	 * Gets the crumbs for a single, non-archive post/page.
	 * 
	 * @access private
	 * @static
	 * @param array $options
	 * @return array
	 */
	private static function get_singular_crumbs(array $options) {
		$post = get_queried_object();
		if (is_null($post)) $post = $GLOBALS['post'];
		$crumbs = array();
		
		$pt = get_post_type_object($post->post_type);
		if (!is_null($pt) 
			&& !is_wp_error($pt) 
			&& $pt->has_archive
			&& $options['post_type_show']
		) {
			$crumbs[] = new HAG_Crumb(
				$options,
				$pt->label,
				get_post_type_archive_link($pt->name),
				false,
				false
			);
		}

		$rev_crumbs = array();
		
		if ($options['last_show']) {
			$rev_crumbs[] = new HAG_Crumb(
				$options,
				$post->post_title,
				get_permalink($post->ID),
				false,
				true
			);
		}
		
		if (is_post_type_hierarchical($pt->name)) {
			
			foreach($post->ancestors as $aID) {
				$ancestor = get_post($aID);
				$rev_crumbs[] = new HAG_Crumb(
					$options,
					$ancestor->post_title,
					get_permalink($ancestor->ID),
					false,
					false
				);
			}
			
		} elseif ($options['taxonomy_show']) {
		
			$tax_names = get_object_taxonomies($post);
			$taxes = get_object_taxonomies($post->post_type, OBJECT);
			$term_args = array('orderby' => 'count', 'order' => 'DESC');			
			$term = null;

			//get preferred taxonomy term if it exists
			if (in_array($options['taxonomy_preferred'], $tax_names)) {
				$tax_name = $options['taxonomy_preferred'];
				$tax = array_key_exists($tax_name, $taxes) ? $taxes[$tax_name] : null;
				if (!is_null($tax)) $terms = HAG_Utils::get_filtered_object_terms($post->ID, $tax_name, $term_args, $options);
				if (count($terms) > 0) $term = $terms[0];
			}
			
			//else, get hierarchical taxonomy term if it exists
			if (is_null($term)) {
				$hier_taxes = array();
				foreach($taxes as $t) if ($t->hierarchical) $hier_taxes[] = $t->name;
				$hier_terms = HAG_Utils::get_filtered_object_terms($post->ID, $hier_taxes, $term_args, $options);
				if (!is_wp_error($hier_terms) && count($hier_terms) > 0) $term = $hier_terms[0];
			}
			
			//else, get non-hierarchical taxonomy term if it exists
			if (is_null($term)) {
				$unhier_taxes = array();
				foreach($taxes as $t) if (!$t->hierarchical) $unhier_taxes[] = $t->name;
				$unhier_terms = HAG_Utils::get_filtered_object_terms($post->ID, $unhier_taxes, $term_args, $options);
				if (!is_wp_error($unhier_terms) && count($unhier_terms) > 0) $term = $unhier_terms[0];
			}
			
			if (!is_null($term)) {
				do {
					$rev_crumbs[] = new HAG_Crumb(
						$options,
						$term->name,
						get_term_link($term),
						false,
						false
					);
					$term = get_term($term->parent, $term->taxonomy);
				} while (!is_wp_error($term) && $options['taxonomy_ancestors_show']);
			}
			
		}
		
		return array_merge($crumbs, array_reverse($rev_crumbs));
	}
	
}
