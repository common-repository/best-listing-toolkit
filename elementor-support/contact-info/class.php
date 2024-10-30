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

class Contact_Info extends Custom_Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		$this->wpwax_name = esc_html__( 'Contact Info', 'best-listing-toolkit' );
		$this->wpwax_base = 'wpwaxtheme-contact-info';
		parent::__construct( $data, $args );
	}

	public function wpwax_fields() {
		$fields = array(

			// General Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_general',
				'label' => esc_html__( 'General', 'best-listing-toolkit' ),
			),
			array(
				'type'        => Controls_Manager::TEXT,
				'id'          => 'heading',
				'label'       => esc_html__( 'Title', 'best-listing-toolkit' ),
				'placeholder' => esc_html__( 'Contact Info', 'best-listing-toolkit' ),
				'default'     => esc_html__( 'Contact Info', 'best-listing-toolkit' ),

			),
			array(
				'type'        => Controls_Manager::TEXTAREA,
				'id'          => 'address',
				'label'       => esc_html__( 'Address', 'best-listing-toolkit' ),
				'placeholder' => esc_html__( 'New Orleans', 'best-listing-toolkit' ),
				'default'     => esc_html__( 'New Orleans', 'best-listing-toolkit' ),

			),
			array(
				'type'        => Controls_Manager::TEXT,
				'id'          => 'phone',
				'label'       => esc_html__( 'Phone', 'best-listing-toolkit' ),
				'placeholder' => esc_html__( '+66 2 246 022', 'best-listing-toolkit' ),
				'default'     => esc_html__( '+66 2 246 022', 'best-listing-toolkit' ),

			),
			array(
				'type'        => Controls_Manager::URL,
				'id'          => 'email',
				'label'       => esc_html__( 'Email Address', 'best-listing-toolkit' ),
				'placeholder' => esc_html__( 'support@wpwax.com', 'best-listing-toolkit' ),
			),
			array(
				'type'        => Controls_Manager::URL,
				'id'          => 'website',
				'label'       => esc_html__( 'Website URL', 'best-listing-toolkit' ),
				'placeholder' => 'https://your-link.com',
			),

			// Socials
			array(
				'label' => esc_html__( 'Social Profiles', 'best-listing-toolkit' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
				'id'    => 'address_heading',
			),
			array(
				'type'  => Controls_Manager::TEXT,
				'id'    => 'facebook',
				'label' => esc_html__( 'Facebook', 'best-listing-toolkit' ),
			),
			array(
				'type'  => Controls_Manager::TEXT,
				'id'    => 'twitter',
				'label' => esc_html__( 'Twitter', 'best-listing-toolkit' ),
			),
			array(
				'type'  => Controls_Manager::TEXT,
				'id'    => 'youtube',
				'label' => esc_html__( 'Youtube', 'best-listing-toolkit' ),
			),
			array(
				'type'  => Controls_Manager::TEXT,
				'id'    => 'instagram',
				'label' => esc_html__( 'Instagram', 'best-listing-toolkit' ),
			),
			array(
				'type'  => Controls_Manager::TEXT,
				'id'    => 'linkedin',
				'label' => esc_html__( 'Linkedin', 'best-listing-toolkit' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Style Section

			array(
				'mode'  => 'section_start',
				'id'    => 'sec_color',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Color', 'best-listing-toolkit' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_color',
				'label'     => esc_html__( 'Title', 'best-listing-toolkit' ),
				'selectors' => array( '{{WRAPPER}} .card.theme-card .card-header.theme-card-header h2' => 'color: {{VALUE}}' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_color',
				'label'     => esc_html__( 'Content', 'best-listing-toolkit' ),
				'selectors' => array( 
					'{{WRAPPER}} .theme-contact-info__content' => 'color: {{VALUE}}',
					'{{WRAPPER}} .theme-contact-info__list .theme-contact-info i' => 'color: {{VALUE}}',
				),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'content_hover_color',
				'label'     => esc_html__( 'Content Link Hover', 'best-listing-toolkit' ),
				'selectors' => array( '{{WRAPPER}} a.theme-contact-info__content:hover' => 'color: {{VALUE}}' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Typography Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_typo',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Typography', 'best-listing-toolkit' ),
			),
			array(
				'mode'     => 'group',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'id'       => 'content_typo',
				'label'    => esc_html__( 'Content Typography', 'best-listing-toolkit' ),
				'selector' => '{{WRAPPER}} .theme-contact-info__content, {{WRAPPER}} .theme-contact-info__list .theme-contact-info i',
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
