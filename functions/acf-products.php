<?php
/* Listado de categorías de woocommerce */
// Render fields at the bottom of variations - does not account for field group order or placement.
add_action( 'woocommerce_product_after_variable_attributes', function ( $loop, $variation_data, $variation ) {
    global $acf_variation; // Custom global variable to monitor index

    $acf_variation = $loop;
    // Add filter to update field name
    add_filter( 'acf/prepare_field', 'acf_prepare_field_update_field_name' );

    // Loop through all field groups
    $acf_field_groups = acf_get_field_groups();
    foreach ( $acf_field_groups as $acf_field_group ) {
        foreach ( $acf_field_group[ 'location' ] as $group_locations ) {
            foreach ( $group_locations as $rule ) {
                // See if field Group has at least one post_type = Variations rule - does not validate other rules
                if ( $rule[ 'param' ] == 'post_type' && $rule[ 'operator' ] == '==' && $rule[ 'value' ] == 'product_variation' ) {
                    // Render field Group
                    acf_render_fields( $variation->ID, acf_get_fields( $acf_field_group ) );

                    break 2;
                }
            }
        }
    }

    // Remove filter
    remove_filter( 'acf/prepare_field', 'acf_prepare_field_update_field_name' );
}, 10, 3 );

// Filter function to update field names
function acf_prepare_field_update_field_name( $field ) {
    global $acf_variation;

    $field[ 'name' ] = preg_replace( '/^acf\[/', "acf[$acf_variation][", $field[ 'name' ] );

    return $field;
}

// Save variation data
add_action( 'woocommerce_save_product_variation', function ( $variation_id, $i = -1 ) {
    // Update all fields for the current variation
    if ( !empty( $_POST[ 'acf' ] ) && is_array( $_POST[ 'acf' ] ) && array_key_exists( $i, $_POST[ 'acf' ] ) && is_array( ( $fields = $_POST[ 'acf' ][ $i ] ) ) ) {
        $unique_updates = array();
        foreach ( $fields as $key => $val ) {
            if ( strpos( $key, 'field_' ) === false ) {
                // repeater fields need to be parsed separately
                foreach ( $val as $repeater_key => $repeater_val ) {
                    if ( !array_key_exists( $repeater_key, $unique_updates ) || !empty( $repeater_val ) ) {
                        $unique_updates[ $repeater_key ] = $repeater_val;
                    }
                }
            } else {
                // non-repeater fields can be parsed normally
                // The repeater fields are repeated here, but empty. This causes the repeater that was updated above to be cleared
                if ( !array_key_exists( $key, $unique_updates ) || !empty( $val ) ) {
                    $unique_updates[ $key ] = $val;
                }
            }
        }
        // Only update each field once
        foreach ( $unique_updates as $key => $val ) {
            update_field( $key, $val, $variation_id );
        }
    }
}, 10, 2 );

// Add "Product Variation" location rule values
function my_acf_location_rule_values_post_type( $choices ) {
    $keys = array_keys( $choices );
    $index = array_search( 'product', $keys );

    $position = $index === false ? count( $choices ) : $index + 1;

    $choices = array_merge(
        array_slice( $choices, 0, $position ),
        array( 'product_variation' => __( 'Product Variation', 'auf' ) ),
        array_slice( $choices, $position )
    );

    return $choices;
}
add_filter( 'acf/location/rule_values/post_type', 'my_acf_location_rule_values_post_type' );

// Add "Product Variation" location rule match
function my_acf_location_rule_match_post_type( $match, $rule, $options, $field_group ) {
    if ( $rule[ 'value' ] == 'product_variation' && isset( $options[ 'post_type' ] ) ) {
        $post_type = $options[ 'post_type' ];

        if ( $rule[ 'operator' ] == "==" ) {
            $match = $post_type == $rule[ 'value' ];
        } elseif ( $rule[ 'operator' ] == "!=" ) {
            $match = $post_type != $rule[ 'value' ];
        }
    }

    return $match;
}
add_filter( 'acf/location/rule_match/post_type', 'my_acf_location_rule_match_post_type', 10, 4 );

//Campos imagen
function my_acf_input_admin_footer() {
?>
<script type="text/javascript">
  (function($) {
    $(document).on('woocommerce_variations_loaded', function () {
      acf.do_action('append', $('#post'));
    })
  })(jQuery);	
</script>
<?php
}
add_action( 'acf/input/admin_footer', 'my_acf_input_admin_footer' );
