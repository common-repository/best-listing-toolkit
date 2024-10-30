<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax\Theme\Elementor;

use Elementor\Widget_Base;
use \ReflectionClass;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Exit if accessed directly

class Custom_Widget_Base extends Widget_Base {

	public $wpwax_prefix = 'best-listing'; // change category prefix here /@dev

	public $wpwax_name;
	public $wpwax_base;
	public $wpwax_category;
	public $wpwax_icon;
	public $wpwax_translate;
	public $wpwax_dir;

	public function __construct( $data = array(), $args = null ) {
		$this->wpwax_category = $this->wpwax_prefix . '-widgets';
		$this->wpwax_icon     = 'wpwaxtheme-el-custom';
		$this->wpwax_dir      = dirname( ( new ReflectionClass( $this ) )->getFileName() );
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return $this->wpwax_base;
	}

	public function get_title() {
		return $this->wpwax_name;
	}

	public function get_icon() {
		return $this->wpwax_icon;
	}

	public function get_categories() {
		return array( $this->wpwax_category );
	}

	// Either Override wpwax_fields() or the default _register_controls()
	protected function wpwax_fields() {
		return array();
	}

	public function wpwax_run_shortcode( $shortcode, $atts = array() ) {
		$html = '';

		foreach ( $atts as $key => $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_html( $value ) );
		}

		$html = sprintf( '[%s%s]', $shortcode, $html );

		echo do_shortcode( $html );
	}

	protected function register_controls() {
		$fields = $this->wpwax_fields();

		foreach ( $fields as $field ) {

			if ( isset( $field['mode'] ) && $field['mode'] == 'section_start' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->start_controls_section( $id, $field );

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'section_end' ) {
				$this->end_controls_section();

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'tabs_start' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->start_controls_tabs( $id );

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'tabs_end' ) {
				$this->end_controls_tabs();

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'tab_start' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->start_controls_tab( $id, $field );

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'tab_end' ) {
				$this->end_controls_tab();

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'group' ) {
				$type          = $field['type'];
				$field['name'] = $field['id'];
				unset( $field['mode'] );
				unset( $field['type'] );
				unset( $field['id'] );
				$this->add_group_control( $type, $field );

			} elseif ( isset( $field['mode'] ) && $field['mode'] == 'responsive' ) {
				$id = $field['id'];
				unset( $field['id'] );
				unset( $field['mode'] );
				$this->add_responsive_control( $id, $field );
				
			} else {
				$id = $field['id'];
				unset( $field['id'] );
				$this->add_control( $id, $field );
			}
		}
	}

	public function wpwax_template( $template, $data = null ) {
		$template_name = '/elementor-support/' . basename( $this->wpwax_dir ) . '/' . $template . '.php';
		
		if ( file_exists( STYLESHEETPATH . $template_name ) ) {
			$file = STYLESHEETPATH . $template_name;
		} elseif ( file_exists( TEMPLATEPATH . $template_name ) ) {
			$file = TEMPLATEPATH . $template_name;
		} else {
			$file = $this->wpwax_dir . '/' . $template . '.php';
		}

		include $file;
	}
}
