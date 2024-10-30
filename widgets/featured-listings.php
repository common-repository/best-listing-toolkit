<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

class Featured_Listings extends \WP_Widget {

	public function __construct() {
		$widget_options = array(
			'classname'   => 'onelisting_featured_listings',
			'description' => esc_html__( 'You can show featured listings by this widget', 'best-listing-toolkit' ),
		);
		parent::__construct(
			'onelisting_featured_listings', // Base ID
			esc_html__( '-Best Listing - Featured Listings', 'best-listing-toolkit' ), // Name
			$widget_options // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$allowWidget = apply_filters( 'atbdp_allow_featured_widget', true );
		
		if ( ! $allowWidget ) {
			return;
		}

		$single_only   = ! empty( $instance['single_only'] ) ? 1 : 0;
		$title         = ! empty( $instance['title'] ) ? esc_html( $instance['title'] ) : esc_html__( 'Featured Listings', 'best-listing-toolkit' );
		$f_listing_num = ! empty( $instance['f_listing_num'] ) ? $instance['f_listing_num'] : 5;
		$cat           = ! empty( $instance['cat'] ) ? $instance['cat'] : 0;
		$orderby       = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'title';
		

		echo wp_kses_post( $args['before_widget'] );
		
		printf( '%s %s %s', wp_kses_post( $args['before_title'] ), esc_html( $instance['title'] ), wp_kses_post( $args['after_title'] ) );

		if ( 0 === $cat ) {
			$featured_args = array(
				'post_type'      => ATBDP_POST_TYPE,
				'orderby'        => $orderby,
				'post_status'    => 'publish',
				'posts_per_page' => (int) $f_listing_num,
				'meta_query'     => array(
					array(
						'key'     => '_featured',
						'value'   => 1,
						'compare' => '=',
					),
				),
			);
		} else {
			$featured_args = array(
				'post_type'      => ATBDP_POST_TYPE,
				'orderby'        => $orderby,
				'post_status'    => 'publish',
				'posts_per_page' => (int) $f_listing_num,
				'meta_query'     => array(
					array(
						'key'     => '_featured',
						'value'   => 1,
						'compare' => '=',
					),
				),
				'tax_query'      => array(
					array(
						'taxonomy' => ATBDP_CATEGORY,
						'field'    => 'term_id',
						'terms'    => array( $cat ),
					),
				),
			);
		}
		$featured_listings = new \WP_Query( $featured_args );
		?>
			<div class="atbd_categorized_listings">
				<ul class="listings">
				
					<?php
					if ( $featured_listings->have_posts() ) {
						
						while ( $featured_listings->have_posts() ) {
							$featured_listings->the_post();
							// get only one parent or high level term object
							$listing_img     = get_post_meta( get_the_ID(), '_listing_img', true );
							$listing_prv_img = get_post_meta( get_the_ID(), '_listing_prv_img', true );
							$price           = get_post_meta( get_the_ID(), '_price', true );
							$price_range     = get_post_meta( get_the_ID(), '_price_range', true );
							$listing_pricing = get_post_meta( get_the_ID(), '_atbd_listing_pricing', true );
							$cats            = get_the_terms( get_the_ID(), ATBDP_CATEGORY );
							?>
							<li>
								<div class="atbd_left_img">

									<?php
									$default_image = get_directorist_option( 'default_preview_image', DIRECTORIST_ASSETS . 'images/grid.jpg' );
									if ( ! empty( $listing_prv_img ) ) {
										echo '<a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( wp_get_attachment_image_url( $listing_prv_img, array( 90, 90 ) ) ) . '" alt="listing image"></a>';
									} elseif ( ! empty( $listing_img[0] ) && empty( $listing_prv_img ) ) {
										echo '<a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( wp_get_attachment_image_url( $listing_img[0], array( 90, 90 ) ) ) . '" alt="listing image"></a>';
									} else {
										echo '<a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( $default_image ) . '" alt="listing image"></a>';
									}
									?>
									
								</div>

								<div class="atbd_right_content">
									<div class="cate_title">
										<h4><a href="<?php echo esc_url( get_post_permalink( get_the_ID() ) ); ?>"><?php echo esc_html( stripslashes( get_the_title() ) ); ?></a></h4>
									</div>

									<?php Directorist_Support::get_rating_reviews_html( get_the_ID() ); ?>

									<?php if ( ! empty( $price ) && ( 'price' === $listing_pricing ) ) : ?>
										
										<span><?php atbdp_display_price( $price ); ?></span>

										<?php 
										else :
											$output = atbdp_display_price_range( $price_range );
											echo $output; // phpcs:ignore WordPress.Security.EscapeOutput
										endif; 
										?>
								</div>

							</li>

							<?php
						}
						wp_reset_postdata();
					}; 
					?>

				</ul>

			</div> <!--ends featured listing-->

		<?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 * @return void
	 */
	public function form( $instance ) {
		$values            = array(
			'single_only' => 0,
		);
		$args['taxonomy']  = ATBDP_CATEGORY;
		$categories        = get_terms( $args );
		$category_dropdown = array( '0' => __( 'All Categories', 'best-listing-toolkit' ) );

		foreach ( $categories as $category ) {
			$category_dropdown[ $category->term_id ] = $category->name;
		}

		$instance      = wp_parse_args( (array) $instance, $values );
		$title         = ! empty( $instance['title'] ) ? esc_html( $instance['title'] ) : esc_html__( 'Featured Listings', 'best-listing-toolkit' );
		$f_listing_num = ! empty( $instance['f_listing_num'] ) ? $instance['f_listing_num'] : 5;

		$orderby = array(
			'date'       => __( 'Date (Recants comes first)', 'best-listing-toolkit' ),
			'title'      => __( 'Title', 'best-listing-toolkit' ),
		);
		?>

			<?php

			$fields = array(
				'title' => array(
					'label' => esc_html__( 'Title', 'best-listing-toolkit' ),
					'type'  => 'text',
				),
				'cat' => array(
					'label'   => esc_html__( 'Category', 'best-listing-toolkit' ),
					'type'    => 'select',
					'options' => $category_dropdown,
				),
				'orderby' => array(
					'label'   => esc_html__( 'Order by', 'best-listing-toolkit' ),
					'type'    => 'select',
					'options' => $orderby,
				),
				'f_listing_num' => array(
					'label' => esc_html__( 'Number of Listings', 'best-listing-toolkit' ),
					'type'  => 'number',
				),
				'single_only' => array(
					'label' => esc_html__( 'Display only on single listing', 'best-listing-toolkit' ),
					'type'  => 'checkbox',
				),
			);

			Widget_Fields::display( $fields, $instance, $this );
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['f_listing_num'] = ( ! empty( $new_instance['f_listing_num'] ) ) ? intval( $new_instance['f_listing_num'] ) : '';
		$instance['single_only']   = isset( $new_instance['single_only'] ) ? 1 : 0;
		$instance['orderby']       = isset( $new_instance['orderby'] ) ? $new_instance['orderby'] : 'date';
		$instance['cat']           = isset( $new_instance['cat'] ) ? $new_instance['cat'] : '';

		return $instance;
	}

}
