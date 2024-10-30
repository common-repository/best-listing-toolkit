<?php
/**
 * Plugin Name:       Best Listing Toolkit
 * Plugin URI:        https://demo.directorist.com/theme/best-listing/
 * Description:       A necessary toolkit created by www.wpwax.com for the Best Listing Theme. Custom elementor widgets and theme widgets are some of the new features that will be added to this plugin.
 * Version:           1.2
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            wpWax
 * Author URI:        https://wpwax.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       best-listing-toolkit
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BESTLISTING_TOOLKIT_BASE_DIR', plugin_dir_path( __FILE__ ) );

class BestListing_Toolkit {

	protected static $instance;

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 20 );
		add_action( 'best_listing_init_after', array( $this, 'after_theme_loaded' ) );
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function load_textdomain() {
		load_plugin_textdomain( 'best-listing-toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}

	public function after_theme_loaded() {


		if ( did_action( 'elementor/loaded' ) ) {
			require_once BESTLISTING_TOOLKIT_BASE_DIR . 'elementor-support/init.php';
		}

		require_once BESTLISTING_TOOLKIT_BASE_DIR . 'widgets/init.php';
	}
}

BestListing_Toolkit::instance();
