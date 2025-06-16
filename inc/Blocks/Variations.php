<?php

/**
 * Block Variations
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks;

use Minami\Blocks\Variations\Btn_Minami_Type;
use Minami\Blocks\Variations\Btn_Orange_Color;
use Minami\Blocks\Variations\Btn_White_Color;
use Minami\Blocks\Variations\Case_Study_Query_Loop;
use Minami\Blocks\Variations\Grid_Card;
use Minami\Blocks\Variations\Grid_Gradient;
use Minami\Blocks\Variations\List_With_Bullet;
use Minami\Blocks\Variations\List_With_Circle;
use Minami\Blocks\Variations\List_With_Gradient_Bullet;
use Minami\Blocks\Variations\List_With_Right_Arrow;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Block_Variations Class
 */
class Variations
{

	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor
	 * (private to enforce singleton pattern).
	 */
	private function __construct()
	{
		// All the initialization tasks.
		$this->register_hooks();
	}


	public function register_hooks()
	{
		// Register block styles.
		add_action('enqueue_block_assets', array($this, 'minami_register_block_styles'));
	}

	/**
	 * Register block variations
	 */
	public function minami_register_block_styles()
	{
		// Register block variations.
		Btn_Minami_Type::get_instance();

		// List_With_Bullet::get_instance();
		// List_With_Gradient_Bullet::get_instance();
		// List_With_Circle::get_instance();
		// List_With_Right_Arrow::get_instance();
	}
}
