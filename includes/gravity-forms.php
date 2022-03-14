<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Populate State Dropdown for GF
 */
add_filter( 'gform_chained_selects_input_choices_1_2_1', 'populate_leashless_states', 10, 7 );
function populate_leashless_states( $input_choices, $form_id, $field, $input_id, $chain_value, $value, $index ) {
	
	$terms = get_terms( array(
		'taxonomy' => 'locations',
		'hide_empty' => false,
		'parent' => 0,
	) );
	if( is_wp_error( $terms ) ) {
		return $input_choices;
	} else {
		$choices = array();
		$choices[] = array(
			'text'       => 'Select your State',
			'value'      => "",
			'isSelected' => true
		);
		foreach($terms as $term) {
			$choices[] = array(
				'text'       => $term->name,
				'value'      => $term->term_id,
				'isSelected' => false
			);
		}
		return $choices;
	}
}

/**
 * Populate County Dropdown for GF
 */
add_filter( 'gform_chained_selects_input_choices_1_2_2', 'populate_leashless_counties', 10, 7 );
function populate_leashless_counties( $input_choices, $form_id, $field, $input_id, $chain_value, $value, $index ) {
 
    $selected_state = $chain_value[ "{$field->id}.1" ];
    if( ! $selected_state ) {
        return $input_choices;
    }
	$terms = get_terms( array(
		'taxonomy' => 'locations',
		'hide_empty' => false,
		'parent' => $selected_state,
	) );
	if( is_wp_error( $terms ) ) {
		return $input_choices;
	} else {
		$choices = array();
		$choices[] = array(
			'text'       => 'Select your County',
			'value'      => "",
			'isSelected' => true
		);
		foreach($terms as $term) {
			$choices[] = array(
				'text'       => $term->name,
				'value'      => $term->term_id,
				'isSelected' => false
			);
		}
		return $choices;
	}
}

/**
 * Create Park in draft when submitted via gform
 */
// submit to sfmc after catalog request
add_action( 'gform_after_submission_1', 'create_leashless_park', 10, 2 );
function create_leashless_park( $entry, $form ) {
	$name = $entry['1'];
	$state = $entry['2.1'];
	$county = $entry['2.2'];
	
	//create draft post
	$args = array(
		'post_title' => $name,
		'post_content' => '',
		'post_type' => 'park'
	);
	$post_id = wp_insert_post($args);
	if( !is_wp_error( $post_id ) ) {
		wp_set_post_terms($post_id,array($state,$county),'locations');
	}
	
	//delete the entry since we don't need it anymore
	GFAPI::delete_entry( $entry['id'] );
}
?>