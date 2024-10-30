<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax\Theme\Elementor;

?>
<div class="theme-section-title">

	<h1 class="theme-section-title__title"><?php echo esc_html( $data['title'] ); ?></h1>

	<?php if ( $data['subtitle'] ) : ?>

		<p class="theme-section-title__subtitle"><?php echo wp_kses_post( $data['subtitle'] ); ?></p>

	<?php endif; ?>
	
</div>
