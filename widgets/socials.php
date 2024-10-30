<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

use BestListing\wpWax\Helper;

class Socials_Widget extends \WP_Widget {
	public function __construct() {
		$id = 'onelisting_author_info_socials';
		parent::__construct(
			$id, // Base ID
			esc_html__( '-Best Listing: Socials', 'best-listing-toolkit' ), // Name
			array( 
				'description' => esc_html__( 'BestL Listing: Socials', 'best-listing-toolkit' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			printf( '%s %s %s', wp_kses_post( $args['before_title'] ), esc_html( $instance['title'] ), wp_kses_post( $args['after_title'] ) );
		}
		?>

		<ul>

			<?php
			if ( ! empty( $instance['facebook'] ) ) {
				?>
				<li><a class="facebook" href="<?php echo esc_url( $instance['facebook'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'facebook-square' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
														 <?php
			}
			if ( ! empty( $instance['twitter'] ) ) {
				?>
				<li><a class="twitter" href="<?php echo esc_url( $instance['twitter'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'twitter' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
														<?php
			}
			if ( ! empty( $instance['linkedin'] ) ) {
				?>
				<li><a class="linkedin" href="<?php echo esc_url( $instance['linkedin'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'linkedin-in' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
														 <?php
			}
			if ( ! empty( $instance['pinterest'] ) ) {
				?>
				<li><a class="pinterest" href="<?php echo esc_url( $instance['pinterest'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'pinterest' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
														  <?php
			}
			if ( ! empty( $instance['instagram'] ) ) {
				?>
				<li><a class="instagram" href="<?php echo esc_url( $instance['instagram'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></i></a></li>
														  <?php
			}
			if ( ! empty( $instance['github'] ) ) {
				?>
				<li><a class="github" href="<?php echo esc_url( $instance['github'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'github' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
													   <?php
			}
			if ( ! empty( $instance['wordpress'] ) ) {
				?>
				<li><a class="wordpress" href="<?php echo esc_url( $instance['wordpress'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'WordPress' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
														  <?php
			}
			if ( ! empty( $instance['youtube'] ) ) {
				?>
				<li><a class="youtube" href="<?php echo esc_url( $instance['youtube'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'play-circle' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
														<?php
			}
			if ( ! empty( $instance['rss'] ) ) {
				?>
				<li><a class="rss" href="<?php echo esc_url( $instance['rss'] ); ?>" target="_blank"><?php echo Helper::get_svg_icon( 'rss-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
													<?php
			}
			?>
			
		</ul>

		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['facebook']  = ( ! empty( $new_instance['facebook'] ) ) ? sanitize_text_field( $new_instance['facebook'] ) : '';
		$instance['twitter']   = ( ! empty( $new_instance['twitter'] ) ) ? sanitize_text_field( $new_instance['twitter'] ) : '';
		$instance['linkedin']  = ( ! empty( $new_instance['linkedin'] ) ) ? sanitize_text_field( $new_instance['linkedin'] ) : '';
		$instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? sanitize_text_field( $new_instance['pinterest'] ) : '';
		$instance['youtube']   = ( ! empty( $new_instance['youtube'] ) ) ? sanitize_text_field( $new_instance['youtube'] ) : '';
		$instance['rss']       = ( ! empty( $new_instance['rss'] ) ) ? sanitize_text_field( $new_instance['rss'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? sanitize_text_field( $new_instance['instagram'] ) : '';
		$instance['github']    = ( ! empty( $new_instance['github'] ) ) ? sanitize_text_field( $new_instance['github'] ) : '';
		$instance['wordpress'] = ( ! empty( $new_instance['wordpress'] ) ) ? sanitize_text_field( $new_instance['wordpress'] ) : '';
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title'      => '',
			'facebook'   => '',
			'twitter'    => '',
			'linkedin'   => '',
			'pinterest'  => '',
			'youtube'    => '',
			'github'     => '',
			'wordpress'  => '',
			'rss'        => '', 
			'instagram'  => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title' => array(
				'label'   => esc_html__( 'Title', 'best-listing-toolkit' ),
				'type'    => 'text',
			),
			'facebook' => array(
				'label'   => __( 'Facebook URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'twitter' => array(
				'label'   => __( 'Twitter URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'linkedin' => array(
				'label'   => __( 'Linkedin URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'pinterest' => array(
				'label'   => __( 'Pinterest URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'instagram' => array(
				'label'   => __( 'Instagram URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'github' => array(
				'label'   => __( 'Github URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'wordpress' => array(
				'label'   => __( 'Wordpress URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'youtube' => array(
				'label'   => __( 'YouTube URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
			'rss' => array(
				'label'   => __( 'Rss Feed URL', 'best-listing-toolkit' ),
				'type'    => 'url',
			),
		);

		Widget_Fields::display( $fields, $instance, $this );
	}
}
