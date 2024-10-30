<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace BestListing\wpWax;

class Widget_Fields {

	public static function init() {
		add_action(
			'admin_footer',
			function() {
				?>
			<style>
				.az_wid_image_area .az-wid-upload-img,
				.az_wid_image_area .az_remove_image,
				.az_wid_image_area .az_wid_preview_image {
					display: inline-block;
					margin: 0 10px 0 0;
					vertical-align: middle;
				}
				.az_wid_image_area .az-wid-upload-img:active {
					vertical-align: middle;
				}
				.az_wid_image_area .az_wid_preview_image {
					max-height: 50px;
					max-width: 170px;
					display: block;
					margin-bottom: 10px;
				}
				.az-wid-field {
					margin: 13px 0;
					font-size: 13px;
					line-height: 1.5;
				}
				.az-wid-field label {
					display: block;
					margin-bottom: 3px;
				}
				.az-wid-field .desc {
					color: #777;
					font-style: italic;
					font-size: 12px;
				}
			</style>
			<script>
				jQuery(document).ready(function($){
					"use strict";
					$("body").on('click', '.az_upload_image', function(event) {
						var btnClicked = $(this);
						var custom_uploader = wp.media({
							multiple: false
						}).on("select", function () {
							var attachment = custom_uploader.state().get("selection").first().toJSON();
							btnClicked.closest(".az_wid_image_area").find(".az-wid-upload-img").val(attachment.id).trigger('change');
							btnClicked.closest(".az_wid_image_area").find(".az_wid_preview_image").attr("src", attachment.url).show();
							btnClicked.closest(".az_wid_image_area").find(".az_remove_image_wrap").show();

						}).open();
					});
					$("body").on('click', '.az_remove_image', function(event) {
						event.preventDefault();
						var $item = $(this).closest(".az_wid_image_area");
						$item.find(".az-wid-upload-img").val("").trigger('change');
						$item.find(".az_wid_preview_image").attr("src", "").hide();
						$item.find(".az_remove_image_wrap").hide();
						return false;
					});
				}(jQuery));
			</script>
				<?php
			} 
		);
	}

	public static function display( $fields, $instance, $object ) {
		foreach ( $fields as $key => $field ) {
			$label   = $field['label'];
			$desc    = ! empty( $field['desc'] ) ? $field['desc'] : false;
			$id      = $object->get_field_id( $key );
			$name    = $object->get_field_name( $key );
			$value   = $instance[ $key ];
			$options = ! empty( $field['options'] ) ? $field['options'] : false;

			if ( method_exists( __CLASS__, $field['type'] ) ) {
				echo '<div class="az-wid-field">';
				call_user_func( array( __CLASS__, $field['type'] ), $id, $name, $value, $label, $options, $field );
				if ( $desc ) {
					echo sprintf( '<div class="desc">%s</div>', esc_html( $desc ) );
				}
				echo '</div>';
			}
		}
	}

	public static function text( $id, $name, $value, $label, $options, $field ) {
		?>
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
		<input class="widefat" type="text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" />
		<?php
	}

	public static function url( $id, $name, $value, $label, $options, $field ) {
		?>
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
		<input class="widefat" type="text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_url( $value ); ?>" />
		<?php
	}

	public static function checkbox( $id, $name, $value, $label, $options, $field ) {
		
		if ( is_array( $options ) ) :
			?>
				<h4><?php echo esc_html( $label ); ?></h4>
			<?php
			foreach ( $options as $key => $_value ) : 
				?>

				<input class="widefat" type="checkbox" id="<?php echo esc_attr( $name . $key ); ?>" name="<?php echo esc_attr( $name . '[]' ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( $key, $value ) ); ?> />
				<label style="display: inline-block;" for="<?php echo esc_attr( $name . $key ); ?>"><?php echo esc_html( $_value ); ?>:</label>
		
				<?php
			endforeach;

			return;

		endif;
		?>
		
		<input class="widefat" type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $value ); ?> />
		<label style="display: inline-block;" for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
		<?php
	}

	public static function number( $id, $name, $value, $label, $options, $field ) {
		$min  = isset( $field['min'] ) ? $field['min'] : 1;
		$max  = isset( $field['max'] ) ? $field['max'] : '';
		$step = isset( $field['step'] ) ? $field['step'] : 1;
		?>
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
		<input class="widefat" type="number" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" />
		<?php
	}

	public static function textarea( $id, $name, $value, $label, $options, $field ) {
		?>
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
		<textarea class="widefat" rows="3" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
		<?php
	}

	public static function select( $id, $name, $value, $label, $options, $field ) {
		?>
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>:</label>
		<select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>">
			<?php foreach ( $options as $key => $option ) : ?>
				<?php $selected = ( $key == $value ) ? ' selected="selected"' : ''; ?>
				<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>><?php echo esc_html( $option ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	public static function image( $id, $name, $value, $label, $options, $field ) {
		$image    = '';
		$disstyle = '';

		if ( $value ) {
			$image = wp_get_attachment_image_src( $value, 'thumbnail' );
			$image = $image[0];
		} else {
			$disstyle = 'display:none;';
		}

		echo '
		<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . ':</label>
		<div class="az_wid_image_area">
		<input name="' . esc_attr( $name ) . '" type="hidden" class="az-wid-upload-img" value="' . esc_attr( $value ) . '" />
		<img src="' . esc_url( $image ) . '" class="az_wid_preview_image" style="' . esc_attr( $disstyle ) . '" alt="" />
		<input class="az_upload_image upload_button_' . esc_attr( $id ) . ' button-primary" type="button" value="' . esc_attr__( 'Choose Image', 'best-listing-toolkit' ) . '" />
		<div class="az_remove_image_wrap" style="' . esc_attr( $disstyle ) . '"><a href="#" class="az_remove_image button" >' . esc_html__( 'Remove Image', 'best-listing-toolkit' ) . '</a></div>
		</div>
		';
	}
}
