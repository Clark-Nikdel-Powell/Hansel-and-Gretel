<?php
namespace HAG;

use HAG\Elements\Base;
use HAG\Elements\Comment;
use HAG\Elements\DebugSection;

final class Debug {

	protected $options;
	protected $context;

	protected $el;
	protected $asComment;

	public function __construct(Options $options, \WP_Query $context)
	{
		$this->options = $options;
		$this->context = $context;
		$this->asComment = $options->get('debug_comment');
	}

	public function display()
	{
		$this->getElement();
		$this->getConditionals();
		$this->getOptions();
		$this->el->display();
	}

	protected function getElement()
	{
		if ($this->asComment) $el = new Comment();
		else $el = new Base();

		$el->setTag('pre');
		$el->setClasses('hag-debug');
		$el->setSeparator(PHP_EOL.PHP_EOL);

		$this->el = $el;
	}

	protected function getContext()
	{
		ob_start();
		var_dump($this->context);
		$context = ob_get_clean();

		$el = new DebugSection('Context');
		$el->appendChild($context);

		$this->el->appendChild($el);
	}

	protected function getConditionals()
	{
		$conditionals = array(
			'is_archive',
			'is_post_type_archive',
			'is_attachment',
			'is_author',
			'is_category',			
			'is_tag',
			'is_tax',
			'is_comments_popup',
			'is_feed',
			'is_comment_feed',
			'is_trackback',
			'is_robots',
			'is_date',
			'is_time',			
			'is_day',
			'is_month',
			'is_year',
			'is_front_page',
			'is_home',
			'is_single',
			'is_page',
			'is_singular',
			'is_preview',
			'is_search',
			'is_404',
			'is_paged',
			'is_main_query'
		);

		$el = new DebugSection('Context Conditionals');

		foreach($conditionals as $conditional) {
			$el->appendChild(sprintf(
				'%s: %b',
				$conditional,
				call_user_func(array($this->context, $conditional))
			));
		}
		
		$this->el->appendChild($el);
	}

	protected function getOptions()
	{
		$el = new DebugSection('Options');

		$options = print_r($this->options->raw(), true);
		if (!$this->asComment) $options = htmlentities($options);

		$el->appendChild($options);

		$this->el->appendChild($el);
	}

}
