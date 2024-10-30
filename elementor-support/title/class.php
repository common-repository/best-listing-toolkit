<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax\Theme\Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Title extends Custom_Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		$this->wpwax_name = __( 'Section Title', 'best-listing-toolkit' );
		$this->wpwax_base = 'wpwaxtheme-title';
		parent::__construct( $data, $args );
	}

	public function wpwax_fields() {
		$fields = array(

			// General Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_general',
				'label' => __( 'General', 'best-listing-toolkit' ),
			),
			array(
				'type'    => Controls_Manager::TEXTAREA,
				'id'      => 'title',
				'label'   => __( 'Title', 'best-listing-toolkit' ),
				'default' => 'Lorem Ipsum',
			),
			array(
				'type'    => Controls_Manager::TEXTAREA,
				'id'      => 'subtitle',
				'label'   => __( 'Subtitle', 'best-listing-toolkit' ),
				'default' => 'Lorem Ipsum has been standard daand scrambled. Rimply dummy text of the printing and typesetting industry',
			),
			array(
				'type'      => Controls_Manager::CHOOSE,
				'id'        => 'content_alginment',
				'label'     => __( 'Alignment', 'best-listing-toolkit' ),
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'best-listing-toolkit' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'best-listing-toolkit' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'best-listing-toolkit' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array( '{{WRAPPER}} .theme-section-title' => 'text-align: {{VALUE}}' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Color Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_style',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => __( 'Color', 'best-listing-toolkit' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_color',
				'label'     => __( 'Title', 'best-listing-toolkit' ),
				'default'   => '#111111',
				'selectors' => array( '{{WRAPPER}} .theme-section-title__title' => 'color: {{VALUE}}' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'subtitle_color',
				'label'     => __( 'Subtitle', 'best-listing-toolkit' ),
				'default'   => '#444444',
				'selectors' => array( '{{WRAPPER}} .theme-section-title__subtitle' => 'color: {{VALUE}}' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Typography Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_style_type',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => __( 'Typography', 'best-listing-toolkit' ),
			),
			array(
				'mode'     => 'group',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'id'       => 'title_typo',
				'label'    => __( 'Title', 'best-listing-toolkit' ),
				'selector' => '{{WRAPPER}} .theme-section-title__title',
			),
			array(
				'mode'     => 'group',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'id'       => 'subtitle_typo',
				'label'    => __( 'Subtitle', 'best-listing-toolkit' ),
				'selector' => '{{WRAPPER}} .theme-section-title__subtitle',
			),
			array(
				'mode' => 'section_end',
			),
		);

		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();

		$template = 'view';

		return $this->wpwax_template( $template, $data );
	}
}
