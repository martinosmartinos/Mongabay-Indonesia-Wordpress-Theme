<?php
add_action( 'init', 'mongabay_tax_register_byline', 0 );
function mongabay_tax_register_byline() {
	
	$labels = array(
		'name'              => _x( 'Bylines', 'taxonomy general name' ),
		'singular_name'     => _x( 'Byline', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Byline' ),
		'popular_items'     => __( 'Popular Byline' ),
		'all_items'         => __( 'All Bylines' ),
		'parent_item'       => NULL,
		'parent_item_colon' => NULL,
		'edit_item'         => __( 'Edit Byline' ),
		'update_item'       => __( 'Update Byline' ),
		'add_new_item'      => __( 'Add New Byline' ),
		'new_item_name'     => __( 'New Byline Name' ),
		'separate_items_with_commas' => __( 'Separate Bylines with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Bylines' ),
		'choose_from_most_used'      => __( 'Choose from the most used Bylines' ),
		'not_found'                  => __( 'No Bylines found.' ),
		'menu_name'         => __( 'Byline' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'with_front' => true,
			'slug' => 'byline'
			)
	);

	register_taxonomy( 'byline', array('post'), $args );
}
?>