<?php
// All this goes in the functions.php file...or make your own file and link to it

//add ACF rule
add_filter('acf/location/rule_values/post_type', 'acf_location_rule_values_Post');
function acf_location_rule_values_Post( $choices ) {
	$choices['product_variation'] = 'Product Variation';
    return $choices;
}



$GLOBALS['wc_loop_variation_id'] = null;

function is_field_group_for_variation($field_group, $variation_data, $variation_post) {
	return (preg_match( '/Variation/i', $field_group['title'] ) == true);
}

add_action( 'woocommerce_product_after_variable_attributes', function( $loop_index, $variation_data, $variation_post ) {
		$GLOBALS['wc_loop_variation_id'] = $variation_post->ID;

		foreach ( acf_get_field_groups() as $field_group ) {
			if ( is_field_group_for_variation( $field_group, $variation_data, $variation_post ) ) {
				acf_render_fields( $variation_post->ID, acf_get_fields( $field_group ) );?>
				<script>
				(function($) {
					acf.do_action('append', $('#post'));
				})(jQuery);
				</script>
				<?php
			}
		}

		$GLOBALS['wc_loop_variation_id'] = null;
	}, 10, 3 );

add_action( 'woocommerce_save_product_variation', function( $variation_id, $loop_index ) {
		if ( !isset( $_POST['acf_variation'][$variation_id] ) ) {
			return;
		}
		if ( ! empty( $_POST['acf_variation'][$variation_id] ) && is_array( $fields = $_POST['acf_variation'][$variation_id] )  ) {
			foreach ( $fields as $key => $val ) {
				update_field( $key, $val, $variation_id );
			}
		}
	}, 10, 2 );

add_filter( 'acf/prepare_field', function ( $field ) {
		if ( !$GLOBALS['wc_loop_variation_id'] ) {
			return $field;
		}

		$field['name'] = preg_replace( '/^acf\[/', 'acf_variation[' . $GLOBALS['wc_loop_variation_id'] . '][', $field['name'] );

		return $field;
	}, 10, 1);

// Custom Product  Variation Settings
add_filter( 'woocommerce_available_variation', 'custom_load_variation_settings_products_fields' );
function custom_load_variation_settings_products_fields( $variations ) {
	
	// duplicate the line for each field, replace 'variation_title' with the name of the created custom field.
	$variations['variation_title'] = get_field('variation_title', $variations[ 'variation_id' ]);
	
	return $variations;
}

?>