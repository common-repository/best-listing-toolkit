<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use BestListing\wpWax\Helper;
?>

<div class="card theme-card theme-contact-info">

	<div class="card-header theme-card-header">

		<?php if ( isset( $data['heading'] ) ) : ?>

			<h2><?php echo esc_html( isset( $data['heading'] ) ? $data['heading'] : '' ); ?></h2>

		<?php endif; ?>

	</div>
	
	<div class="card-body theme-card-body">

		<div class="theme-contact-info__list">

			<ul class="list-unstyled">

				<?php if ( isset( $data['address'] ) && ! empty( $data['address'] ) ) : ?>

					<li>

						<div class="theme-contact-info">

							<span class="theme-contact-info__icon"><?php echo Helper::get_svg_icon( 'map-marker-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>

							<p class="theme-contact-info__content"><?php echo esc_html( $data['address'] ); ?></p>

						</div>

					</li>

				<?php endif; ?>

				<?php if ( isset( $data['phone'] ) && ! empty( $data['phone'] ) ) : ?>

					<li>

						<div class="theme-contact-info theme-contact-info-phone">

							<span class="theme-contact-info__icon"><?php echo Helper::get_svg_icon( 'phone-alt-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							
						</span>

							<p class="theme-contact-info__content"><?php echo esc_html( $data['phone'] ); ?></p>

						</div>

					</li>

				<?php endif; ?>

				<?php if ( isset( $data['email'] ) && ! empty( $data['email']['url'] ) ) : ?>

					<li>

						<div class="theme-contact-info">

							<span class="theme-contact-info__icon"><?php echo Helper::get_svg_icon( 'envelope-open' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>

							<?php 
							printf(
								'<a href="%s" class="theme-contact-info__content"%s%s>%s</a>',
								esc_url( isset( $data['email']['url'] ) ? 'mailto:' . $data['email']['url'] : '#' ),
								wp_kses_post( $data['email']['is_external'] === 'on' ? $data['email']['is_external'] : ' target="_blank"' ),
								wp_kses_post( $data['email']['nofollow'] === 'on' ? $data['email']['nofollow'] : ' rel="nofollow"' ),
								esc_url( $data['email']['url'] ) ? $data['email']['url'] : '' 
							);
							?>
						</div>

					</li>

				<?php endif; ?>

				<?php if ( isset( $data['website'] ) && ! empty( $data['website']['url'] ) ) : ?>

					<li>

						<div class="theme-contact-info">

							<span class="theme-contact-info__icon"><?php echo Helper::get_svg_icon( 'globe-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>

							<?php 
							printf(
								'<a href="%s" class="theme-contact-info__content"%s%s>%s</a>',
								esc_url( isset( $data['website']['url'] ) ? $data['website']['url'] : '#' ),
								wp_kses_post( $data['website']['is_external'] === 'on' ? $data['website']['is_external'] : ' target="_blank"' ),
								wp_kses_post( $data['website']['nofollow'] === 'on' ? $data['website']['nofollow'] : ' rel="nofollow"' ),
								esc_url( $data['website']['url'] ) ? $data['website']['url'] : '' 
							);
							?>

						</div>

					</li>

				<?php endif; ?>

			</ul>

		</div>

		<div class="theme-contact-info__socials">

			<ul class="list-unstyled">

				<?php if ( isset( $data['facebook'] ) && ! empty( $data['facebook'] ) ) : ?>

					<li class="theme-contact-facebook"><a href="<?php echo wp_kses_post( $data['facebook'] ); ?>"><?php echo Helper::get_svg_icon( 'facebook-square' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

				<?php endif; ?>

				<?php if ( isset( $data['twitter'] ) && ! empty( $data['twitter'] ) ) : ?>

					<li class="theme-contact-twitter"><a href="<?php echo wp_kses_post( $data['twitter'] ); ?>"><?php echo Helper::get_svg_icon( 'twitter' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

				<?php endif; ?>

				<?php if ( isset( $data['youtube'] ) && ! empty( $data['youtube'] ) ) : ?>

					<li class="theme-contact-youtube"><a href="<?php echo wp_kses_post( $data['youtube'] ); ?>"><?php echo Helper::get_svg_icon( 'youtube' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

				<?php endif; ?>

				<?php if ( isset( $data['instagram'] ) && ! empty( $data['instagram'] ) ) : ?>

					<li class="theme-contact-instagram"><a href="<?php echo wp_kses_post( $data['instagram'] ); ?>"><?php echo Helper::get_svg_icon( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

				<?php endif; ?>

				<?php if ( isset( $data['linkedin'] ) && ! empty( $data['linkedin'] ) ) : ?>

					<li class="theme-contact-linkedin"><a href="<?php echo wp_kses_post( $data['linkedin'] ); ?>"><?php echo Helper::get_svg_icon( 'linkedin-in' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>

				<?php endif; ?>

			</ul>

		</div>

	</div>

</div>
