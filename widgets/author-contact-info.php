<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

class Author_Contact_Info extends \WP_Widget {

	public function __construct() {
		$id = 'single_listing_contact_info';
		parent::__construct(
			$id, // Base ID
			esc_html__( '-Best Listing: Author Contact Info', 'best-listing-toolkit' ), // Name
			array(
				'description' => esc_html__( 'Only for Listing details page.', 'best-listing-toolkit' ),
			) 
		);
	}

	public function widget( $args, $instance ) {
		
		$title             = $instance['title'];
		$info_meta         = $instance['info_meta'];
		$social_icon       = ( 1 == $instance['social_icon'] || 'yes' === $instance['social_icon'] ) ? 'yes' : 'no';
		$contact_btn       = ( 1 == $instance['contact_btn'] || 'yes' === $instance['contact_btn'] ) ? 'yes' : 'no';
		$contact_btn_label = $instance['contact_btn_label'];
		$author_btn        = ( 1 == $instance['author_btn'] || 'yes' === $instance['author_btn'] ) ? 'yes' : 'no';
		$author_btn_label  = $instance['author_btn_label'];

		$listing_id      = get_the_ID();
		$author_id       = get_post_field( 'post_author', $listing_id );
		$author_name     = get_the_author_meta( 'display_name', $author_id );
		$user_registered = get_the_author_meta( 'user_registered', $author_id );
		$u_pro_pic       = get_user_meta( $author_id, 'pro_pic', true );
		$u_pro_pic       = ! empty( $u_pro_pic ) ? wp_get_attachment_image_src( $u_pro_pic, 'thumbnail' ) : '';
		$avatar_img      = get_avatar( $author_id, apply_filters( 'atbdp_avatar_size', 32 ) );

		$address    = esc_attr( get_user_meta( $author_id, 'address', true ) );
		$phone      = esc_attr( get_user_meta( $author_id, 'atbdp_phone', true ) );
		$email      = get_the_author_meta( 'user_email', $author_id );
		$website    = get_the_author_meta( 'user_url', $author_id );
		$facebook   = get_user_meta( $author_id, 'atbdp_facebook', true );
		$twitter    = get_user_meta( $author_id, 'atbdp_twitter', true );
		$linkedIn   = get_user_meta( $author_id, 'atbdp_linkedin', true );
		$youtube    = get_user_meta( $author_id, 'atbdp_youtube', true );
		$email_show = get_directorist_option( 'display_author_email', 'public' );

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $title ) ) {
			printf( '%s %s %s', wp_kses_post( $args['before_title'] ), esc_html( $instance['title'] ), wp_kses_post( $args['after_title'] ) );
		}
		?>

		<div class="atbdp atbd_author_info_widget">

			<div class="atbd_avatar_wrapper">

				<div class="atbd_review_avatar">

					<?php
					if ( empty( $u_pro_pic ) ) {
						echo $avatar_img; // phpcs:ignore WordPress.Security.EscapeOutput
					}

					if ( ! empty( $u_pro_pic ) ) {
						?>

						<img src="<?php echo esc_url( $u_pro_pic[0] ); ?>" alt="Avatar Image">

					<?php } ?>

				</div>

				<div class="atbd_name_time">

					<h4><?php echo esc_html( $author_name ); ?></h4>

					<span class="review_time"><?php echo sprintf( esc_html__( 'Posted %s ago', 'best-listing-toolkit' ), esc_html( human_time_diff( strtotime( get_the_date() ) ), current_time( 'timestamp' ) ) ); ?></span>

				</div>

			</div>

			<?php if ( is_array( $info_meta ) ) : ?>

				<div class="atbd_widget_contact_info">

					<ul>

						<?php if ( in_array( 'address', $info_meta ) && ! empty( $address ) ) { ?>
							<li>
								<?php directorist_icon( 'las la-map-marker' ); ?>
								<span class="atbd_info"><?php echo ! empty( $address ) ? esc_html( $address ) : ''; ?></span>
							</li>
						<?php } ?>

						<?php if ( in_array( 'phone', $info_meta ) && isset( $phone ) && ! is_empty_v( $phone ) ) : ?>

							<!-- In Future, We will have to use a loop to print more than 1 number-->
							<li>
								<?php directorist_icon( 'las la-phone' ); ?>
								<span class="atbd_info"><a href="tel:<?php echo esc_html( stripslashes( $phone ) ); ?>"><?php echo esc_html( stripslashes( $phone ) ); ?></a></span>
							</li>

							<?php 
						endif;

						if ( in_array( 'mail', $info_meta ) && 'public' === $email_show ) {

							if ( ! empty( $email ) ) {
								?>

								<li>
									<?php directorist_icon( 'las la-envelope' ); ?>
									<span class="atbd_info"><?php echo esc_html( $email ); ?></span>
								</li>

								<?php 
							}                       
						} elseif ( in_array( 'mail', $info_meta ) && 'logged_in' === $email_show ) {

							if ( is_user_logged_in() ) {

								if ( ! empty( $email ) ) {
									?>

										<li>
											<?php directorist_icon( 'las la-envelope' ); ?>
											<span class="atbd_info"><?php echo esc_html( $email ); ?></span>
										</li>

									<?php 
								}
							}
						}

						if ( in_array( 'web', $info_meta ) && ! empty( $website ) ) : 
							?>

								<li>
									<?php directorist_icon( 'las la-globe' ); ?>
									<a href="<?php echo esc_url( $website ); ?>" class="atbd_info" <?php echo is_directoria_active() ? 'style="text-transform: none;"' : ''; ?>><?php echo esc_url( $website ); ?></a>
								</li>

						<?php endif; ?>

					</ul>

				</div>
			
			<?php endif; ?>


			<?php if ( 'yes' === $social_icon && ! empty( $facebook || $twitter || $linkedIn || $youtube ) ) : ?>

				<div class="atbd_social_wrap">

					<?php
					if ( $facebook ) {
						printf( '<p><a target="_blank" href="%s">%s</a></p>', esc_url( $facebook ), directorist_icon( 'la la-facebook', false ) ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					if ( $twitter ) {
						printf( '<p><a target="_blank" href="%s">%s</a></p>', esc_url( $twitter ), directorist_icon( 'la la-twitter', false ) ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					if ( $linkedIn ) {
						printf( '<p><a target="_blank" href="%s">%s</a></p>', esc_url( $linkedIn ), directorist_icon( 'la la-linkedin', false ) ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					if ( $youtube ) {
						printf( '<p><a target="_blank" href="%s">%s</a></p>', esc_url( $youtube ), directorist_icon( 'la la-youtube', false ) ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					?>

				</div>

			<?php endif; ?>

			<?php if ( 'yes' == $contact_btn ) : ?>
				<a href="#" class="btn btn-primary theme-btn btn-contact" data-bs-toggle="modal" data-bs-target="#theme-author-contact-modal"><?php echo esc_html( $contact_btn_label ); ?></a>
			<?php endif; ?>

			<?php if ( 'yes' === $author_btn ) : ?>
				<a href="<?php echo esc_url( \ATBDP_Permalink::get_user_profile_page_link( $author_id ) ); ?>" class="<?php echo esc_attr( atbdp_directorist_button_classes() ); ?>"><?php echo esc_html( $author_btn_label ); ?></a>
			<?php endif; ?>

		</div>

		<?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ) {
		$instance                      = array();
		$instance['title']             = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['contact_btn_label'] = ( ! empty( $new_instance['contact_btn_label'] ) ) ? sanitize_text_field( $new_instance['contact_btn_label'] ) : '';
		$instance['author_btn_label']  = ( ! empty( $new_instance['author_btn_label'] ) ) ? sanitize_text_field( $new_instance['author_btn_label'] ) : '';
		$instance['info_meta']         = ( ! empty( $new_instance['info_meta'] ) ? $new_instance['info_meta'] : array( 'address', 'phone', 'mail', 'web' ) );
		$instance['contact_btn']       = ( ! empty( $new_instance['contact_btn'] ) ? $new_instance['contact_btn'] : 'yes' );
		$instance['author_btn']        = ( ! empty( $new_instance['author_btn'] ) ? $new_instance['author_btn'] : 'yes' );
		$instance['social_icon']       = ( ! empty( $new_instance['social_icon'] ) ? $new_instance['social_icon'] : 'yes' );

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title'             => __( 'Contact Info', 'best-listing-toolkit' ),
			'contact_btn_label' => __( 'Contact Owner', 'best-listing-toolkit' ),
			'author_btn_label'  => __( 'View Profile', 'best-listing-toolkit' ),
			'info_meta'         => array( 'address', 'phone', 'mail', 'web' ),
			'contact_btn'       => 'yes',
			'author_btn'        => 'yes',
			'social_icon'       => 'yes',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title' => array(
				'label' => esc_html__( 'Title', 'best-listing-toolkit' ),
				'type'  => 'text',
			),
			'info_meta' => array(
				'label'   => esc_html__( 'Choose Info Meta', 'best-listing-toolkit' ),
				'type'    => 'checkbox',
				'options' => array(
					'address' => __( 'Address', 'best-listing-toolkit' ),
					'phone'   => __( 'Phone Number', 'best-listing-toolkit' ),
					'mail'    => __( 'Mail', 'best-listing-toolkit' ),
					'web'     => __( 'Web Address', 'best-listing-toolkit' ),
				),
				'default' => array( 'address', 'phone', 'mail', 'web' ),
			),
			'social_icon' => array(
				'label'   => esc_html__( 'Show Social Icon?', 'best-listing-toolkit' ),
				'type'    => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'best-listing-toolkit' ),
					'no'  => __( 'No', 'best-listing-toolkit' ),
				),
			),
			'contact_btn' => array(
				'label'   => esc_html__( 'Show Contact Owner Button?', 'best-listing-toolkit' ),
				'type'    => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'best-listing-toolkit' ),
					'no'  => __( 'No', 'best-listing-toolkit' ),
				),
			),
			'contact_btn_label' => array(
				'label' => esc_html__( 'Contact Owner Button Label', 'best-listing-toolkit' ),
				'type'  => 'text',
			),
			'author_btn' => array(
				'label'   => esc_html__( 'Show Author Profile Button?', 'best-listing-toolkit' ),
				'type'    => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'best-listing-toolkit' ),
					'no'  => __( 'No', 'best-listing-toolkit' ),
				),
			),
			'author_btn_label'  => array(
				'label' => esc_html__( 'Author Profile Button Label', 'best-listing-toolkit' ),
				'type'  => 'text',
			),

		);

		Widget_Fields::display( $fields, $instance, $this );
	}
}
