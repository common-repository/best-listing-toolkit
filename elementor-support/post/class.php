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

class Post extends Custom_Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		$this->wpwax_name = __( 'Post', 'best-listing-toolkit' );
		$this->wpwax_base = 'wpwaxtheme-post';
		parent::__construct( $data, $args );
	}

	private function wpwax_query( $data ) {
		$args = array(
			'cat'                 => (int) $data['cat'],
			'orderby'             => $data['orderby'],
			'posts_per_page'      => $data['number_of_post'],
			'post_status'         => 'publish',
			'suppress_filters'    => false,
			'ignore_sticky_posts' => true,
		);

		switch ( $data['orderby'] ) {
			case 'title':
			case 'menu_order':
				$args['order'] = 'ASC';
				break;
		}

		return new \WP_Query( $args );
	}

	public function wpwax_fields() {

		$categories        = get_categories();
		$category_dropdown = array( '0' => __( 'All Categories', 'best-listing-toolkit' ) );

		foreach ( $categories as $category ) {
			$category_dropdown[ $category->term_id ] = $category->name;
		}

		$fields = array(

			// General Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_general',
				'label' => __( 'General', 'best-listing-toolkit' ),
			),
			array(
				'type'    => Controls_Manager::NUMBER,
				'id'      => 'number_of_post',
				'label'   => __( 'Number of Posts', 'best-listing-toolkit' ),
				'default' => 3,
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'number_of_columns',
				'label'   => __( 'Columns', 'best-listing-toolkit' ),
				'options' => array(
					'2' => __( '6 Columns', 'best-listing-toolkit' ),
					'3' => __( '4 Columns', 'best-listing-toolkit' ),
					'4' => __( '3 Columns', 'best-listing-toolkit' ),
					'6' => __( '2 Columns', 'best-listing-toolkit' ),
				),
				'default' => 4,

			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'cat',
				'label'   => __( 'Categories', 'best-listing-toolkit' ),
				'options' => $category_dropdown,
				'default' => '0',
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'orderby',
				'label'   => __( 'Order By', 'best-listing-toolkit' ),
				'options' => array(
					'date'       => __( 'Date (Recents comes first)', 'best-listing-toolkit' ),
					'title'      => __( 'Title', 'best-listing-toolkit' ),
					'menu_order' => __( 'Custom Order (Available via Order field inside Page Attributes box)', 'best-listing-toolkit' ),
				),
				'default' => 'date',
			),
			array(
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'id'        => 'show_excpert',
				'label'     => __( 'Show Excerpt', 'best-listing-toolkit' ),
				'label_on'  => __( 'Show', 'best-listing-toolkit' ),
				'label_off' => __( 'Hide', 'best-listing-toolkit' ),
				'default'   => 'no',
			),
			array(
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'id'        => 'show_date',
				'label'     => __( 'Show Date', 'best-listing-toolkit' ),
				'label_on'  => __( 'Show', 'best-listing-toolkit' ),
				'label_off' => __( 'Hide', 'best-listing-toolkit' ),
				'default'   => 'yes',
			),
			array(
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'id'        => 'show_reading_time',
				'label'     => __( 'Show Reading Time', 'best-listing-toolkit' ),
				'label_on'  => __( 'Show', 'best-listing-toolkit' ),
				'label_off' => __( 'Hide', 'best-listing-toolkit' ),
				'default'   => 'yes',
			),
			array(
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'id'        => 'show_category',
				'label'     => __( 'Show Categories', 'best-listing-toolkit' ),
				'label_on'  => __( 'Show', 'best-listing-toolkit' ),
				'label_off' => __( 'Hide', 'best-listing-toolkit' ),
				'default'   => 'no',
			),
			array(
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'id'        => 'show_more_button',
				'label'     => __( 'Show More Button', 'best-listing-toolkit' ),
				'label_on'  => __( 'Show', 'best-listing-toolkit' ),
				'label_off' => __( 'Hide', 'best-listing-toolkit' ),
				'default'   => 'yes',
			),
			array(
				'type'      => \Elementor\Controls_Manager::TEXT,
				'id'        => 'show_more_button_text',
				'label'     => __( 'Button Text', 'best-listing-toolkit' ),
				'default'   => esc_html__( 'See all the guides', 'best-listing-toolkit' ),
				'condition' => array( 'show_more_button' => array( 'yes' ) ),
			),
			array(
				'mode' => 'section_end',
			),

			// Color Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_color',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => __( 'Color', 'best-listing-toolkit' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_color',
				'label'     => __( 'Title', 'best-listing-toolkit' ),
				'default'   => '#111111',
				'selectors' => array( '{{WRAPPER}} .theme-blog-card__title a' => 'color: {{VALUE}}' ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'excpert_color',
				'label'     => __( 'Excerpt', 'best-listing-toolkit' ),
				'default'   => '#444444',
				'selectors' => array( '{{WRAPPER}} .theme-blog-card__summary' => 'color: {{VALUE}}' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Typography Section
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_typo',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => __( 'Typography', 'best-listing-toolkit' ),
			),
			array(
				'mode'     => 'group',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'id'       => 'title_typo',
				'label'    => __( 'Title', 'best-listing-toolkit' ),
				'selector' => '{{WRAPPER}} .theme-blog-card__title',
			),
			array(
				'mode'     => 'group',
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'id'       => 'excpert_typo',
				'label'    => __( 'Excerpt', 'best-listing-toolkit' ),
				'selector' => '{{WRAPPER}} .theme-blog-card__summary',
			),
			array(
				'mode' => 'section_end',
			),

		);

		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();

		$data['query'] = $this->wpwax_query( $data );

		$template = 'view'; 

		return $this->wpwax_template( $template, $data );
	}
}
