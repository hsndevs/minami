<?php

namespace Minami\Blocks\Variations;

class Grid_Card
{
	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.
	public function __construct()
	{
		register_block_style('core/group', array(
			'name'         => 'grid-card',
			'label'        => __('Grid Card', 'minami'),
			'inline_style' => '
				.wp-block-post .wp-block-group is-style-grid-card {
					padding:10px!important;
				}
			'
		));
	}
}
