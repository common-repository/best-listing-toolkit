<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

use \WP_Widget;

class Post_Widget extends WP_Widget {
	public function __construct() {
		$id = 'onelisting_post';
		parent::__construct(
			$id, // Base ID
			esc_html__( '-Best Listing: Posts', 'best-listing-toolkit' ), // Name
			array(
				'description' => esc_html__( 'Best Listing: Posts', 'best-listing-toolkit' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			printf( '%s %s %s', wp_kses_post( $args['before_title'] ), esc_html( $instance['title'] ), wp_kses_post( $args['after_title'] ) );
		}

		$q_args = array(
			'cat'                 => (int) $instance['cat'],
			'orderby'             => $instance['orderby'],
			'posts_per_page'      => $instance['number'],
			'ignore_sticky_posts' => true,
		);

		switch ( $instance['orderby'] ) {
			case 'title':
			case 'menu_order':
				$q_args['order'] = 'ASC';
				break;
		}

		$query      = new \WP_Query( $q_args );
		$thumb_size = 'wpwaxtheme-size3';

		if ( $query->have_posts() ) :
			?>

			<div class='row theme-row'> 
				
				<?php 
				while ( $query->have_posts() ) :
					$query->the_post(); 
					?>

					<div class="col-lg-4">

						<div class="theme-blog-each">

							<div class="theme-blog-card blog-grid-card">
								
								<?php if ( has_post_thumbnail() ) : ?>
									
									<div class="theme-blog-card__thumbnail">

										<a class="theme-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb_size ); ?><div class="theme-icon"><i class="flaticon-plus-symbol"></i></div></a>
									
									</div>
								
								<?php else : ?>

									<div class="theme-blog-card__thumbnail">

										<a class="theme-thumb" href="<?php the_permalink(); ?>"><img alt="<?php the_title(); ?>" src="<?php echo esc_url( Helper::get_img( 'nothumb.png' ) ); ?>"><div class="theme-icon"><i class="flaticon-plus-symbol"></i></div></a>
									
									</div>

								<?php endif; ?>	

								<div class="theme-blog-card__details">

									<div class="theme-blog-card__content">

										<h3 class="theme-blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									</div>

									<div class="theme-blog-card__meta">

										<ul class="list-unstyled">

											<li class="theme-blog-card_date-meta">

												<span class="theme-blog-card_date-meta-text"><?php the_time( get_option( 'date_format' ) ); ?></span>

											</li>

										</ul>

									</div>
									
								</div>

							</div>

						</div>

					</div>

				<?php endwhile; ?> 

			</div> 

		<?php else : ?>

			<div>

				<?php esc_html_e( 'Currently there are no posts to display', 'best-listing-toolkit' ); ?>

			</div>

			<?php 
		endif;
		wp_reset_postdata();

		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['cat']     = ( ! empty( $new_instance['cat'] ) ) ? sanitize_text_field( $new_instance['cat'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : '';
		$instance['number']  = ( ! empty( $new_instance['number'] ) ) ? sanitize_text_field( $new_instance['number'] ) : '';

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title'   => '',
			'cat'     => '0',
			'orderby' => '',
			'number'  => '5',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$categories        = get_categories();
		$category_dropdown = array( '0' => __( 'All Categories', 'best-listing-toolkit' ) );

		foreach ( $categories as $category ) {
			$category_dropdown[ $category->term_id ] = $category->name;
		}

		$orderby = array(
			'date'       => __( 'Date (Recants comes first)', 'best-listing-toolkit' ),
			'title'      => __( 'Title', 'best-listing-toolkit' ),
			'menu_order' => __( 'Custom Order (Available via Order field inside Page Attributes box)', 'best-listing-toolkit' ),
		);

		$fields = array(
			'title'   => array(
				'label' => esc_html__( 'Title', 'best-listing-toolkit' ),
				'type'  => 'text',
			),
			'cat'     => array(
				'label'   => esc_html__( 'Category', 'best-listing-toolkit' ),
				'type'    => 'select',
				'options' => $category_dropdown,
			),
			'orderby' => array(
				'label'   => esc_html__( 'Order by', 'best-listing-toolkit' ),
				'type'    => 'select',
				'options' => $orderby,
			),
			'number'  => array(
				'label' => esc_html__( 'Number of Post', 'best-listing-toolkit' ),
				'type'  => 'number',
			),
		);

		Widget_Fields::display( $fields, $instance, $this );
	}
}
