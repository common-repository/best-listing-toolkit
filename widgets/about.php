<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

use BestListing\wpWax\Helper;

class About_Widget extends \WP_Widget {

	public function __construct() {
		$id = 'onelisting_about';
		parent::__construct(
			$id, // Base ID
			esc_html__( '-Best Listing: About', 'best-listing-toolkit' ), // Name
			array(
				'description' => esc_html__( 'About( Footer )', 'best-listing-toolkit' ),
			) 
		);
	}

	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			printf( '%s %s %s', wp_kses_post( $args['before_title'] ), esc_html( $instance['title'] ), wp_kses_post( $args['after_title'] ) );
		}
		?>

		<div class="theme-about-widget">

			<?php
			if ( ! empty( $instance['logo'] ) ) {
				$html    = '';
				$img     = wp_get_attachment_image_src( $instance['logo'], 'full' );
				$img_url = $img[0];
				$html   .= '<div class="theme-about-widget__img"><img src="' . $img_url . '" alt="' . $img_url . '"></div>';
				echo wp_kses_post( $html );
			}
			?>

			<p class="theme-about-widget__content">

				<?php 
				if ( ! empty( $instance['description'] ) ) {
					echo wp_kses_post( $instance['description'] );
				}
				?>

			</p>

			<div class="theme-about-widget__social">

				<ul class="list-unstyled d-flex flex-wrap">

					<?php if ( ! empty( $instance['facebook'] ) ) : ?>

						<li class="theme-about-widget__social--facebook"><a href="<?php echo esc_url( $instance['facebook'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'facebook-square' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>

					<?php if ( ! empty( $instance['twitter'] ) ) : ?>

						<li class="theme-about-widget__social--twitter"><a href="<?php echo esc_url( $instance['twitter'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'twitter' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>

					<?php if ( ! empty( $instance['linkedin'] ) ) : ?>

						<li class="theme-about-widget__social--linkedin"><a href="<?php echo esc_url( $instance['linkedin'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'linkedin-in' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>


					<?php if ( ! empty( $instance['pinterest'] ) ) : ?>

						<li class="theme-about-widget__social--pinterest"><a href="<?php echo esc_url( $instance['pinterest'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'pinterest' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>

					<?php if ( ! empty( $instance['instagram'] ) ) : ?>

						<li class="theme-about-widget__social--instagram"><a href="<?php echo esc_url( $instance['instagram'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>

					<?php if ( ! empty( $instance['youtube'] ) ) : ?>

						<li class="theme-about-widget__social--youtube"><a href="<?php echo esc_url( $instance['youtube'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'youtube' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>


					<?php if ( ! empty( $instance['rss'] ) ) : ?>

						<li class="theme-about-widget__social--rss"><a href="<?php echo esc_url( $instance['rss'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'rss-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>


					<?php if ( ! empty( $instance['vimeo'] ) ) : ?>

						<li class="theme-about-widget__social--vimeo"><a href="<?php echo esc_url( $instance['vimeo'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'vimeo' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

					<?php endif; ?>

				</ul>

			</div>

		</div>

		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['logo']        = ( ! empty( $new_instance['logo'] ) ) ? sanitize_text_field( $new_instance['logo'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? wp_kses_post( $new_instance['description'] ) : '';
		$instance['facebook']    = ( ! empty( $new_instance['facebook'] ) ) ? sanitize_text_field( $new_instance['facebook'] ) : '';
		$instance['twitter']     = ( ! empty( $new_instance['twitter'] ) ) ? sanitize_text_field( $new_instance['twitter'] ) : '';
		$instance['linkedin']    = ( ! empty( $new_instance['linkedin'] ) ) ? sanitize_text_field( $new_instance['linkedin'] ) : '';
		$instance['pinterest']   = ( ! empty( $new_instance['pinterest'] ) ) ? sanitize_text_field( $new_instance['pinterest'] ) : '';
		$instance['instagram']   = ( ! empty( $new_instance['instagram'] ) ) ? sanitize_text_field( $new_instance['instagram'] ) : '';
		$instance['youtube']     = ( ! empty( $new_instance['youtube'] ) ) ? sanitize_text_field( $new_instance['youtube'] ) : '';
		$instance['rss']         = ( ! empty( $new_instance['rss'] ) ) ? sanitize_text_field( $new_instance['rss'] ) : '';
		$instance['vimeo']       = ( ! empty( $new_instance['vimeo'] ) ) ? sanitize_text_field( $new_instance['vimeo'] ) : '';

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title'       => '',
			'logo'        => '',
			'description' => '',
			'facebook'    => '',
			'twitter'     => '',
			'linkedin'    => '',
			'pinterest'   => '',
			'instagram'   => '',
			'youtube'     => '',
			'rss'         => '',
			'vimeo'       => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'       => array(
				'label' => esc_html__( 'Title', 'best-listing-toolkit' ),
				'type'  => 'text',
			),
			'logo'        => array(
				'label' => esc_html__( 'Logo', 'best-listing-toolkit' ),
				'type'  => 'image',
			),
			'description' => array(
				'label' => esc_html__( 'Description', 'best-listing-toolkit' ),
				'type'  => 'textarea',
			),
			'facebook'    => array(
				'label' => esc_html__( 'Facebook URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'twitter'     => array(
				'label' => esc_html__( 'Twitter URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'linkedin'    => array(
				'label' => esc_html__( 'Linkedin URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'pinterest'   => array(
				'label' => esc_html__( 'Pinterest URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'instagram'   => array(
				'label' => esc_html__( 'Instagram URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'youtube'     => array(
				'label' => esc_html__( 'YouTube URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'rss'         => array(
				'label' => esc_html__( 'Rss Feed URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
			'vimeo'       => array(
				'label' => esc_html__( 'Vimeo URL', 'best-listing-toolkit' ),
				'type'  => 'url',
			),
		);

		Widget_Fields::display( $fields, $instance, $this );
	}
}
