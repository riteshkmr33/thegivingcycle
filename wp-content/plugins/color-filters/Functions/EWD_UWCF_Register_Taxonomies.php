<?php
/**
 * Add new taxonomy, make it hierarchical. This is the main taxonomy which handles product color.
 *
 */
function EWD_UWCF_Register_Taxonomies() {
	$Enable_Colors = get_option("EWD_UWCF_Enable_Colors");
	$Enable_Sizes = get_option("EWD_UWCF_Enable_Sizes");

	$labels = array(
		'name'              => _x( 'Colors', 'Color', 'elm' ),
		'singular_name'     => _x( 'Color', 'Color', 'elm' ),
		'search_items'      => __( 'Search Colors', 'elm' ),
		'all_items'         => __( 'All Colors', 'elm' ),
		'parent_item'       => __( 'Parent Color', 'elm' ),
		'parent_item_colon' => __( 'Parent Color:', 'elm' ),
		'edit_item'         => __( 'Edit Color', 'elm' ),
		'update_item'       => __( 'Update Color', 'elm' ),
		'add_new_item'      => __( 'Add New Color', 'elm' ),
		'new_item_name'     => __( 'New Color Name', 'elm' ),
		'menu_name'         => __( 'Colors', 'elm' ),
	);
 
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'product-color' )
	);
 
	if ($Enable_Colors == 'Yes' or $Enable_Colors == "") {register_taxonomy( 'product_color', array( 'product' ), $args );}

	$labels = array(
		'name'              => _x( 'Sizes', 'Size', 'elm' ),
		'singular_name'     => _x( 'Size', 'Size', 'elm' ),
		'search_items'      => __( 'Search Sizes', 'elm' ),
		'all_items'         => __( 'All Sizes', 'elm' ),
		'parent_item'       => __( 'Parent Size', 'elm' ),
		'parent_item_colon' => __( 'Parent Size:', 'elm' ),
		'edit_item'         => __( 'Edit Size', 'elm' ),
		'update_item'       => __( 'Update Size', 'elm' ),
		'add_new_item'      => __( 'Add New Size', 'elm' ),
		'new_item_name'     => __( 'New Size Name', 'elm' ),
		'menu_name'         => __( 'Sizes', 'elm' ),
	);
 
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'product-size' )
	);
 
	if ($Enable_Sizes == 'Yes' or $Enable_Sizes == "") {register_taxonomy( 'product_size', array( 'product' ), $args );}

}
add_action( 'init', 'EWD_UWCF_Register_Taxonomies' );
?>