<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax\Theme\Elementor;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Exit if accessed directly

class Widget_Init {

	public $prefix;
	public $category;
	public $widgets;
	public $pro_widgets;

	public function __construct() {
		$this->init();
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_style' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'widget_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/widgets/register', array( $this, 'pro_register_widgets' ) );
	}

	private function init() {
		$this->prefix   = 'best-listing';
		$this->category = __( 'Theme Elements', 'best-listing-toolkit' );

		// Widgets -- dirname=>classname
		$theme_widgets = array(
			'title'        => 'Title',
			'contact-info' => 'Contact_Info',
			'post'         => 'Post',
		);
		
		$dir_theme_widgets = array();
		if ( class_exists( 'Directorist_Base' ) ) {
			$dir_theme_widgets = array(
				'all-listings'        => 'All_Listing',
				'search-listing'      => 'Search_Listing',
			);
		}

		$this->widgets = array_merge( $theme_widgets, $dir_theme_widgets );

		// Pro-Widgets -- dirname=>classname
		$pro_theme_widgets = array();
		if ( defined( 'BESTLISTING_PRO_BASE_DIR' ) ) {
			$pro_theme_widgets = array(
				'cta'          => 'CTA',
				'counter'      => 'Counter',
				'testimonial'  => 'Testimonial',
			);
		}

		$pro_dir_theme_widgets = array();
		if ( class_exists( 'Directorist_Base' ) && defined( 'BESTLISTING_PRO_BASE_DIR' ) ) {
			$pro_dir_theme_widgets = array(
				'listing-categories'  => 'Listing_Categories',
				'single-location-box' => 'Single_Location_Box',
			);
		}

		$this->pro_widgets = array_merge( $pro_theme_widgets, $pro_dir_theme_widgets );
	}

	public function editor_style() {
		$img = get_stylesheet_directory_uri() . '/elementor-support/icon.png';
		wp_add_inline_style( 'elementor-editor', '.elementor-control-type-select2 .elementor-control-input-wrapper {min-width: 130px;}.elementor-element .icon .wpwaxtheme-el-custom{content: url(' . $img . ');width: 22px;}' );
	}

	public function widget_category( $class ) {
		$id         = $this->prefix . '-widgets';
		$properties = array(
			'title' => $this->category,
		);

		Plugin::$instance->elements_manager->add_category( $id, $properties );
	}

	public function register_widgets() {
		require_once __DIR__ . '/class-base.php';

		foreach ( $this->widgets as $dirname => $class ) {
			$template_name = '/elementor-support/' . $dirname . '/class.php';

			if ( file_exists( STYLESHEETPATH . $template_name ) ) {
				$file = STYLESHEETPATH . $template_name;
			} elseif ( file_exists( TEMPLATEPATH . $template_name ) ) {
				$file = TEMPLATEPATH . $template_name;
			} else {
				$file = __DIR__ . '/' . $dirname . '/class.php';
			}

			// Include Widget files
			require_once $file;

			// Register widget
			$classname = __NAMESPACE__ . '\\' . $class;
			Plugin::instance()->widgets_manager->register( new $classname() );
		}
	}

	public function pro_register_widgets() {
		// Checked - is active pro plugin
		if ( ! defined( 'BESTLISTING_PRO_BASE_DIR' ) ) {
			return;
		}

		require_once __DIR__ . '/class-base.php';

		foreach ( $this->pro_widgets as $dirname => $class ) {
			$template_name = '/elementor-support/' . $dirname . '/class.php';

			if ( file_exists( STYLESHEETPATH . $template_name ) ) {
				$file = STYLESHEETPATH . $template_name;
			} elseif ( file_exists( TEMPLATEPATH . $template_name ) ) {
				$file = TEMPLATEPATH . $template_name;
			} else {
				$file = BESTLISTING_PRO_BASE_DIR . 'elementor-support/' . $dirname . '/class.php';
			}

			// Include Widget files
			require_once $file;

			// Register widget
			$classname = __NAMESPACE__ . '\\' . $class;
			Plugin::instance()->widgets_manager->register( new $classname() );
		}
	}
}

new Widget_Init();
