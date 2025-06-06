<?php

namespace Minami\Blocks\Variations;

class Case_Study_Query_Loop
{
	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{
		register_block_style('core/query', array(
			'name'         => 'case-study-query-loop',
			'label'        => __('Case Study', 'minami'),
		));
	}
}
