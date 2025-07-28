<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName

/**
 * Plugin File: AM API
 * Description: This plugin will show related random posts under each post.
 *
 * @package wordpress-plugin
 * @since 1.0
 */

namespace Minami;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/Libs/Tgmpa/class-tgm-plugin-activation.php';

/**
 * Tgmpa Class
 *
 * This class handles the registration of required plugins using the TGM Plugin Activation library.
 */
class Tgmpa {
	use Traits\Singleton; // Use the Singleton trait to ensure only one instance of this class exists.
	use Traits\PluginData; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor (private to enforce singleton pattern).
	 *
	 * @return void
	 */
	private function __construct() {
		// All the initialization tasks.
		add_action( 'tgmpa_register', array( $this, 'minami_register_required_plugins' ) );
	}

	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variables passed to the `tgmpa()` function should be:
	 * - an array of plugin arrays;
	 * - optionally a configuration array.
	 * If you are not changing anything in the configuration array, you can remove the array and remove the
	 * variable from the function call: `tgmpa( $plugins );`.
	 * In that case, the TGMPA default settings will be used.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	public function minami_register_required_plugins() {
		/*
		* Array of plugin arrays. Required keys are name and slug.
		* If the source is NOT from the .org repo, then source is also required.
		*/
		$plugins = array(
			array(
				'name'        => 'Contact Form 7',
				'slug'        => 'contact-form-7',
				'is_callable' => 'wpcf7',
			),
		);

		/*
		* Array of configuration settings. Amend each line as needed.
		*
		* TGMPA will start providing localized text strings soon. If you already have translations of our standard
		* strings available, please help us make TGMPA even better by giving us access to these translations or by
		* sending in a pull-request with .po file(s) with the translations.
		*
		* Only uncomment the strings in the config array if you want to customize the strings.
		*/
		$config = array(
			'id'           => 'minami',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
}
