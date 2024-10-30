<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax\Theme\Elementor;

use BestListing\wpWax\Helper;

$thumb_size = 'wpwaxtheme-size2';
$query      = $data['query'];
$columns    = $data['number_of_columns'];
$show_btn   = ( isset( $data['show_more_button'] ) && 'yes' === $data['show_more_button'] ) ? true : false;
$blog_url   = get_option( 'page_for_posts', false );
$btn_text   = isset( $data['show_more_button_text'] ) ? $data['show_more_button_text'] : esc_html__( 'See all the guides', 'best-listing-toolkit' );

if ( $query->have_posts() ) : ?>

	<div class="row theme-row">

		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$get_cat_ob = get_the_category();
			$cat_link   = get_category_link( $get_cat_ob[0]->cat_ID );
			$cat_name   = $get_cat_ob[0]->name;
			?>

			<div class="col-lg-<?php echo esc_attr( $columns ); ?> col-md-6 col-12">

				<div id="post-<?php the_ID(); ?>" <?php post_class( 'theme-blog-each' ); ?>>

					<div class="theme-blog-card blog-grid-card">

						<?php if ( has_post_thumbnail() ) : ?>

							<div class="theme-blog-card__thumbnail">

								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb_size ); ?></a>

							</div>

						<?php else : ?>

							<div class="theme-blog-card__thumbnail">
								
								<a href="<?php the_permalink(); ?>">

									<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_url( Helper::get_img( 'nothumb.png' ) ); ?>">

								</a>

							</div>
							

						<?php endif; ?>

						<div class="theme-blog-card__details">

							<div class="theme-blog-card__content">

								<h2 class="theme-blog-card__title">

									<a href="<?php the_permalink(); ?>" class="entry-title" rel="bookmark"><?php the_title(); ?></a>

								</h2>

								<?php if ( $data['show_excpert'] ) : ?>

									<div class="theme-blog-card__summary entry-summary">
										<?php the_excerpt(); ?>
									</div>

								<?php endif; ?>

							</div>

							<?php if ( $data['show_date'] || $data['show_category'] || $data['show_reading_time'] ) : ?>

								<div class="theme-blog-card__meta">

									<div class="theme-blog-card__meta-list">

										<ul class="list-unstyled">

											<?php if ( $data['show_date'] ) : ?>

												<li class="theme-blog-card_date-meta">

													<span class="theme-blog-card_date-meta-text updated published"><?php the_time( get_option( 'date_format' ) ); ?></span>
												
												</li>

											<?php endif; ?>

											<?php if ( $data['show_reading_time'] ) : ?>

												<li class="theme-blog-card_reading-time-meta"><?php echo wp_kses( Helper::get_reading_time( get_the_content(), 'span' ), 'span' ); ?></li>

											<?php endif; ?>

											<?php if ( $data['show_category'] ) : ?>

												<li class="theme-blog-card_category-meta">
												
													<span class="theme-blog-card_category-meta-label"><?php echo esc_html__( 'In', 'best-listing-toolkit' ); ?> </span>
													
													<a href="<?php echo esc_url( $cat_link ); ?>" class="theme-blog-cat"><?php printf( '%s', esc_html( $cat_name ) ); ?></a>
												
												</li>

											<?php endif; ?>

										</ul>

									</div>

								</div>

							<?php endif; ?>

						</div>

					</div>

				</div>

			</div>

		<?php endwhile; ?>

	</div>

	<?php if ( $blog_url && $show_btn ) : ?>

		<div class="theme-more-btn">

			<a href="<?php echo esc_url( get_permalink( $blog_url ) ); ?>"><span class="theme-more-btn__text"><?php echo esc_html( $btn_text ); ?></span> <i aria-hidden="true" class="fas fa-long-arrow-alt-right"></i></a>

		</div>

	<?php endif; ?>

<?php else : ?>

	<div><?php echo esc_html__( 'Currently there are no posts', 'best-listing-toolkit' ); ?></div>

<?php endif; ?>

<?php wp_reset_postdata(); ?>
