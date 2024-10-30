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

class All_Listing extends Custom_Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		$this->wpwax_name = __( 'All Listings', 'best-listing-toolkit' );
		$this->wpwax_base = 'wpwaxtheme-all-listings';
		parent::__construct( $data, $args );
	}

	private function wpwax_listing_categories() {
		$result     = array();
		$categories = get_terms( ATBDP_CATEGORY );
		foreach ( $categories as $category ) {
			$result[ $category->slug ] = $category->name;
		}

		return $result;
	}

	private function wpwax_listing_tags() {
		$result = array();
		$tags   = get_terms( ATBDP_TAGS );
		foreach ( $tags as $tag ) {
			$result[ $tag->slug ] = $tag->name;
		}

		return $result;
	}

	private function wpwax_listing_locations() {
		$result    = array();
		$locations = get_terms( ATBDP_LOCATION );
		foreach ( $locations as $location ) {
			$result[ $location->slug ] = $location->name;
		}

		return $result;
	}

	private function wpwax_listing_types() {
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

	private function wpwax_all_listing() {
		$all_listings = array();

		$_all_listings = get_posts( array( 'post_type' => ATBDP_POST_TYPE ) );
		// get_posts( ['post_type' => ATBDP_POST_TYPE ]);

		foreach ( $_all_listings as $listing ) {
			$all_listings[ $listing->ID ] = $listing->post_title;
		}

		// e_var_dump( $all_listings );

		return $all_listings;
	}

	public function wpwax_fields() {
		$fields = array(
			array(
				'mode'  => 'section_start',
				'id'    => 'sec_general',
				'label' => __( 'General', 'best-listing-toolkit' ),
			),
			array(
				'type'      => Controls_Manager::SWITCHER,
				'id'        => 'show_directory_types',
				'label'     => __( 'Show Directory Types?', 'best-listing-toolkit' ),
				'default'   => 'yes',
				'condition' => Helper::multi_directory_enabled() ? '' : array( 'nocondition' => true ),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'type',
				'label'     => __( 'Directory Types', 'best-listing-toolkit' ),
				'multiple'  => true,
				'options'   => $this->wpwax_listing_types(),
				'condition' => ! Helper::multi_directory_enabled() ? '' : array(
					'show_directory_types' => array( 'yes' ),
					'specify_listings'     => '',
				),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'default_type',
				'label'     => __( 'Select Directory Type', 'best-listing-toolkit' ),
				'options'   => $this->wpwax_listing_types(),
				'condition' => ! Helper::multi_directory_enabled() ? '' : array(
					'show_directory_types' => '',
				),
			),
			array(
				'type'    => Controls_Manager::SWITCHER,
				'id'      => 'specify_listings',
				'label'   => __( 'Show Only Selected Listings?', 'best-listing-toolkit' ),
				'default' => '',
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'ids',
				'label'     => __( 'Specify Listings', 'best-listing-toolkit' ),
				'multiple'  => true,
				'options'   => $this->wpwax_all_listing(),
				'condition' => array( 'specify_listings' => 'yes' ),
			),
			array(
				'type'    => Controls_Manager::SELECT,
				'id'      => 'view',
				'label'   => __( 'Layout', 'best-listing-toolkit' ),
				'options' => array(
					'grid' => __( 'Grid View', 'best-listing-toolkit' ),
					'list' => __( 'List View', 'best-listing-toolkit' ),
				),
				'default' => 'grid',
			),
			array(
				'type'      => Controls_Manager::SELECT,
				'id'        => 'columns',
				'label'     => __( 'Listings Per Row', 'best-listing-toolkit' ),
				'options'   => array(
					'5' => __( '5 Items / Row', 'best-listing-toolkit' ),
					'4' => __( '4 Items / Row', 'best-listing-toolkit' ),
					'3' => __( '3 Items / Row', 'best-listing-toolkit' ),
					'2' => __( '2 Items / Row', 'best-listing-toolkit' ),
				),
				'default'   => '3',
				'condition' => array( 'view' => 'grid' ),
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'listing_number',
				'label'     => __( 'Number of Listings', 'best-listing-toolkit' ),
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 6,
				'condition' => array( 'specify_listings' => '' ),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'cat',
				'label'     => __( 'Specify Categories', 'best-listing-toolkit' ),
				'multiple'  => true,
				'options'   => $this->wpwax_listing_categories(),
				'condition' => array( 'specify_listings' => '' ),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'location',
				'label'     => __( 'Specify Locations', 'best-listing-toolkit' ),
				'multiple'  => true,
				'options'   => $this->wpwax_listing_locations(),
				'condition' => array( 'specify_listings' => '' ),
			),
			array(
				'type'      => Controls_Manager::SELECT2,
				'id'        => 'tag',
				'label'     => __( 'Specify Tags', 'best-listing-toolkit' ),
				'multiple'  => true,
				'options'   => $this->wpwax_listing_tags(),
				'condition' => array( 'specify_listings' => '' ),
			),
			array(
				'type'      => Controls_Manager::SELECT,
				'id'        => 'order_list',
				'label'     => __( 'Order', 'best-listing-toolkit' ),
				'options'   => array(
					'asc'  => __( ' ASC', 'best-listing-toolkit' ),
					'desc' => __( ' DESC', 'best-listing-toolkit' ),
				),
				'default'   => 'desc',
				'condition' => array( 'specify_listings' => '' ),
			),
			array(
				'type'      => Controls_Manager::SELECT,
				'id'        => 'order_by',
				'label'     => __( 'Order by', 'best-listing-toolkit' ),
				'options'   => array(
					'title' => __( 'Title', 'best-listing-toolkit' ),
					'date'  => __( 'Date', 'best-listing-toolkit' ),
					'price' => __( 'Price', 'best-listing-toolkit' ),
				),
				'default'   => 'date',
				'condition' => array(
					'specify_listings' => '',
				),
			),
			array(
				'mode' => 'section_end',
			),
		);

		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();
		$ids  = $data['ids'];

		if ( is_array( $ids ) ) {
			$ids = implode( ',', $data['ids'] );
		}

		$atts = array(
			'header'               => 'no',
			'header_title'         => '',
			'advanced_filter'      => 'no',
			'view'                 => $data['view'],
			'columns'              => $data['columns'],
			'listings_per_page'    => $data['listing_number'],
			'show_pagination'      => 'no',
			'category'             => $data['cat'] ? implode( ',', $data['cat'] ) : '',
			'tag'                  => $data['tag'] ? implode( ',', $data['tag'] ) : '',
			'location'             => $data['location'] ? implode( ',', $data['location'] ) : '',
			'orderby'              => $data['order_by'],
			'order'                => $data['order_list'],
			'show_title'           => 'no',
			'show_directory_types' => $data['show_directory_types'],
			'ids'                  => $ids,
		);

		if ( Helper::multi_directory_enabled() ) {
			if ( $data['type'] ) {
				$atts['directory_type'] = implode( ',', $data['type'] );
			}
			if ( $data['default_type'] ) {
				$atts['default_directory_type'] = $data['default_type'];
			}
		}

		$this->wpwax_run_shortcode( 'directorist_all_listing', $atts );
	}
}
