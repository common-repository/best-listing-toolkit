<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax\Theme\Elementor;

use Directorist\Helper;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Search_Listing extends Custom_Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		$this->wpwax_name = esc_html__( 'Search Form', 'best-listing-toolkit' );
		$this->wpwax_base = 'wpwax-search-listing';
		parent::__construct( $data, $args );
	}

	private function az_listing_types() {
		$listing_types = array();
		$all_types     = get_terms(
			array(
				'taxonomy'   => ATBDP_TYPE,
				'hide_empty' => false,
			) 
		);

		foreach ( $all_types as $type ) {
			$listing_types[ $type->slug ] = $type->name;
		}

		return $listing_types;
	}

	public function wpwax_fields() {
		$fields = array(
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_general',
				'label' => esc_html__( 'General', 'best-listing-toolkit' ),
			),
			array(
				'type'    => Controls_Manager::SWITCHER,
				'id'      => 'show_subtitle',
				'label'   => esc_html__( 'Element Title and Subtitle?', 'best-listing-toolkit' ),
				'default' => 'yes',
			),
			array(
				'mode'      => 'responsive',
				'type'      => Controls_Manager::CHOOSE,
				'id'        => 'title_subtitle_alignment',
				'label'     => esc_html__( 'Title/Subtitle Alignment', 'best-listing-toolkit' ),
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'best-listing-toolkit' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'best-listing-toolkit' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'best-listing-toolkit' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .directorist-search-top__title'    => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .directorist-search-top__subtitle' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .directorist-container-fluid'      => 'text-align: {{VALUE}}',
				),
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::TEXTAREA,
				'id'        => 'title',
				'label'     => esc_html__( 'Search Form Title', 'best-listing-toolkit' ),
				'default'   => esc_html__( 'Search here', 'best-listing-toolkit' ),
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'id'         => 'max_width',
				'mode'       => 'responsive',
				'label'      => esc_html__( 'Title Max Width', 'best-listing-toolkit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'px' => array(
						'max' => 1600,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .directorist-search-top__title' => 'max-width: {{SIZE}}{{UNIT}}' ),
				'condition'  => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::TEXTAREA,
				'id'        => 'subtitle',
				'label'     => esc_html__( 'Search Form Subtitle', 'best-listing-toolkit' ),
				'default'   => esc_html__( 'Find the best match of your interest', 'best-listing-toolkit' ),
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'type',
				'label'     => esc_html__( 'Directory Types', 'best-listing-toolkit' ),
				'multiple'  => true,
				'options'   => $this->az_listing_types(),
				'condition' => Helper::multi_directory_enabled() ? '' : array( 'nocondition' => true ),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'default_type',
				'label'     => esc_html__( 'Default Directory Type', 'best-listing-toolkit' ),
				'options'   => $this->az_listing_types(),
				'condition' => Helper::multi_directory_enabled() ? '' : array( 'nocondition' => true ),
			),
			array(
				'type'    => Controls_Manager::TEXT,
				'id'      => 'search_btn_text',
				'label'   => esc_html__( 'Search Button Label', 'best-listing-toolkit' ),
				'default' => esc_html__( 'Search Listing', 'best-listing-toolkit' ),
			),
			array(
				'type'    => Controls_Manager::SWITCHER,
				'id'      => 'show_more_filter_btn',
				'label'   => esc_html__( 'Show More Search Field?', 'best-listing-toolkit' ),
				'default' => 'yes',
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'more_filter_btn_text',
				'label'     => esc_html__( 'More Search Field Button Label', 'best-listing-toolkit' ),
				'default'   => esc_html__( 'More Filters', 'best-listing-toolkit' ),
				'condition' => array( 'show_more_filter_btn' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'more_filter_reset_btn',
				'label'     => esc_html__( 'Show More Field Reset Button?', 'best-listing-toolkit' ),
				'default'   => 'yes',
				'condition' => array( 'show_more_filter_btn' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'more_filter_reset_btn_text',
				'label'     => esc_html__( 'More Field Reset Button Label', 'best-listing-toolkit' ),
				'default'   => esc_html__( 'Reset Filters', 'best-listing-toolkit' ),
				'condition' => array(
					'more_filter_reset_btn' => 'yes',
					'show_more_filter_btn'  => 'yes',
				),
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'more_filter_search_btn',
				'label'     => esc_html__( 'Show More Field Search Button?', 'best-listing-toolkit' ),
				'default'   => 'yes',
				'condition' => array( 'show_more_filter_btn' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'more_filter_search_btn_text',
				'label'     => esc_html__( 'More Field Search Button Label', 'best-listing-toolkit' ),
				'default'   => esc_html__( 'Apply Filters', 'best-listing-toolkit' ),
				'condition' => array(
					'more_filter_search_btn' => 'yes',
					'show_more_filter_btn'   => 'yes',
				),
			),
			array(
				'type'      => Controls_Manager::SELECT,
				'id'        => 'more_filter',
				'label'     => esc_html__( 'More Filter By', 'best-listing-toolkit' ),
				'options'   => array(
					'overlapping' => esc_html__( 'Overlapping', 'best-listing-toolkit' ),
					'always_open' => esc_html__( 'Always Open', 'best-listing-toolkit' ),
				),
				'default'   => 'overlapping',
				'condition' => array( 'show_more_filter_btn' => array( 'yes' ) ),
			),
			array(
				'type'    => Controls_Manager::SWITCHER,
				'id'      => 'show_popular_category',
				'label'   => esc_html__( 'Show popular categories', 'best-listing-toolkit' ),
				'default' => 'no',
			),
			array(
				'type'      => Controls_Manager::TEXT,
				'id'        => 'popular_cat_num',
				'label'     => esc_html__( 'Number of Popular Categories', 'best-listing-toolkit' ),
				'default'   => '3',
				'condition' => array( 'show_popular_category' => 'yes' ),
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'      => 'section_start',
				'id'        => 'sec_style',
				'tab'       => Controls_Manager::TAB_STYLE,
				'label'     => esc_html__( 'Color', 'best-listing-toolkit' ),
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'title_color',
				'label'     => esc_html__( 'Title', 'best-listing-toolkit' ),
				'default'   => '#51526e',
				'selectors' => array(
					'{{WRAPPER}} .directorist-search-top__title' => 'color: {{VALUE}}',
				),
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'subtitle_color',
				'label'     => esc_html__( 'Subtitle', 'best-listing-toolkit' ),
				'default'   => '#51526e',
				'selectors' => array( '{{WRAPPER}} .directorist-search-top__subtitle' => 'color: {{VALUE}}' ),
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'show_popular_category_color',
				'label'     => esc_html__( 'Popular Categories', 'best-listing-toolkit' ),
				'default'   => '#565865',
				'selectors' => array(
					'{{WRAPPER}} .directorist-listing-category-top p'              => 'color: {{VALUE}}',
					'{{WRAPPER}} .directorist-listing-category-top a span::before' => 'color: {{VALUE}}',
				),
				'condition' => array( 'show_popular_category' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'show_popular_category_color_hover',
				'label'     => esc_html__( 'Popular Categories Hover', 'best-listing-toolkit' ),
				'default'   => '#51526e',
				'selectors' => array(
					'{{WRAPPER}} .directorist-listing-category-top p:hover'              => 'color: {{VALUE}}',
					'{{WRAPPER}} .directorist-listing-category-top a:hover span::before' => 'color: {{VALUE}}',
				),
				'condition' => array( 'show_popular_category' => array( 'yes' ) ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'multi_dir_color_active',
				'label'     => esc_html__( 'Directory Type', 'best-listing-toolkit' ),
				'default'   => 'rgba(255, 255, 255, 0.7)',
				'selectors' => array(
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item a' => 'color: {{VALUE}}',
				),
				'condition' => Helper::multi_directory_enabled() ? '' : array( 'nocondition' => true ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'multi_dir_color_hover',
				'label'     => esc_html__( 'Directory Type Hover', 'best-listing-toolkit' ),
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item a:hover'        => 'color: {{VALUE}}',
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item a:hover::after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item a:hover::after' => 'background-color: {{VALUE}}',
				),
				'condition' => Helper::multi_directory_enabled() ? '' : array( 'nocondition' => true ),
			),
			array(
				'type'      => Controls_Manager::COLOR,
				'id'        => 'multi_dir_color',
				'label'     => esc_html__( 'Directory Type Active', 'best-listing-toolkit' ),
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item .directorist-listing-type-selection__link--current' => 'color: {{VALUE}}',
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item a:after'                                            => 'color: {{VALUE}}',
					'{{WRAPPER}} .directorist-search-contents .directorist-listing-type-selection .directorist-listing-type-selection__item a:after'                                            => 'background-color: {{VALUE}}',
				),
				'condition' => Helper::multi_directory_enabled() ? '' : array( 'nocondition' => true ),
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_style_type',
				'tab'   => Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Typography', 'best-listing-toolkit' ),
			),
			array(
				'mode'      => 'group',
				'type'      => \Elementor\Group_Control_Typography::get_type(),
				'id'        => 'title_typo',
				'label'     => esc_html__( 'Title', 'best-listing-toolkit' ),
				'selector'  => '{{WRAPPER}} .directorist-search-top__title',
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),

			),
			array(
				'mode'      => 'group',
				'type'      => \Elementor\Group_Control_Typography::get_type(),
				'id'        => 'subtitle_typo',
				'label'     => esc_html__( 'Subtitle', 'best-listing-toolkit' ),
				'selector'  => '{{WRAPPER}} .directorist-search-top__subtitle',
				'condition' => array( 'show_subtitle' => array( 'yes' ) ),
			),
			array(
				'mode'      => 'group',
				'type'      => \Elementor\Group_Control_Typography::get_type(),
				'id'        => 'show_popular_category_typo',
				'label'     => esc_html__( 'Popular Categories', 'best-listing-toolkit' ),
				'selector'  => '{{WRAPPER}} .directorist-listing-category-top h3, {{WRAPPER}} .directorist-listing-category-top a p, {{WRAPPER}} .directorist-listing-category-top a span',
				'condition' => array( 'show_popular_category' => array( 'yes' ) ),
			),
			array(
				'mode' => 'section_end',
			),
		);

		return $fields;
	}

	public function best_listing_elementor_settings_data() {
		return $this->get_settings();
	}

	protected function render() {
		$data = $this->get_settings();

		$atts = array(
			'show_title_subtitle'   => $data['show_subtitle'],
			'search_bar_title'      => $data['title'],
			'search_bar_sub_title'  => $data['subtitle'],
			'search_button_text'    => $data['search_btn_text'],
			'more_filters_button'   => $data['show_more_filter_btn'],
			'more_filters_text'     => $data['more_filter_btn_text'],
			'reset_filters_button'  => $data['more_filter_reset_btn'],
			'apply_filters_button'  => $data['more_filter_search_btn'],
			'reset_filters_text'    => $data['more_filter_reset_btn_text'],
			'apply_filters_text'    => $data['more_filter_search_btn_text'],
			'more_filters_display'  => $data['more_filter'],
			'show_popular_category' => $data['show_popular_category'],
			'popular_cat_num'       => $data['popular_cat_num'],
			'popular_cat_title'     => '',
		);

		if ( Helper::multi_directory_enabled() ) {
			if ( $data['type'] ) {
				$atts['directory_type'] = implode( ',', $data['type'] );
			}
			if ( $data['default_type'] ) {
				$atts['default_directory_type'] = $data['default_type'];
			}
		}

		add_filter( 'best_listing_elementor_settings_data', array( $this, 'best_listing_elementor_settings_data' ) );

		$this->wpwax_run_shortcode( 'directorist_search_listing', $atts );
	}
}
