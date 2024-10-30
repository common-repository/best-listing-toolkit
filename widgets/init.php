<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

class Custom_Widgets_Init {

	public $widgets;
	protected static $instance = null;

	public function __construct() {

		// Widgets -- filename=>classname /@dev
		$widgets1 = array(
			'about'   => 'About_Widget',
			'post'    => 'Post_Widget',
			'socials' => 'Socials_Widget',
		);

		if ( class_exists( 'Directorist_Base' ) ) {
			$directorist = array(
				'author-contact-info' => 'Author_Contact_Info',
				'featured-listings'   => 'Featured_Listings',
			);
		} else {
			$directorist = array();
		}

		$this->widgets = array_merge( $widgets1, $directorist );

		add_action( 'widgets_init', array( $this, 'custom_widgets' ) );
	}

	public static function instance() {

		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function custom_widgets() {
		require_once __DIR__ . '/base.php';

		Widget_Fields::init();

		foreach ( $this->widgets as $filename => $classname ) {
			$file  = dirname( __FILE__ ) . '/' . $filename . '.php';
			$class = __NAMESPACE__ . '\\' . $classname;

			require_once $file;

			register_widget( $class );
		}

	}

}

Custom_Widgets_Init::instance();
