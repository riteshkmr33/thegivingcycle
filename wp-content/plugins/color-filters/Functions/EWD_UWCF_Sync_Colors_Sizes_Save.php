<?php
add_action('save_post_product', 'EWD_UWCF_Add_Product_Save_ID');
function EWD_UWCF_Add_Product_Save_ID($post_id){
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	update_option("EWD_UWCF_Update_Products", $post_id);
}

add_action('init', 'EWD_UWCF_Sync_Colors_Sizes_Save', 99);
function EWD_UWCF_Sync_Colors_Sizes_Save() {
	$post_id = get_option("EWD_UWCF_Update_Products");

	if (!$post_id) {return;}

	$Colors_Product_Page_Display = get_option("EWD_UWCF_Colors_Product_Page_Display");
	$Colors_Visible = ($Colors_Product_Page_Display == "No" ? false : true);
	$Colors_Used_For_Variations = get_option("EWD_UWCF_Colors_Used_For_Variations");
	$Colors_Variation= ($Colors_Used_For_Variations == "No" ? false : true);

	$Sizes_Product_Page_Display = get_option("EWD_UWCF_Sizes_Product_Page_Display");
	$Sizes_Visible = ($Sizes_Product_Page_Display == "No" ? false : true);
	$Sizes_Used_For_Variations = get_option("EWD_UWCF_Sizes_Used_For_Variations");
	$Sizes_Variation = ($Sizes_Used_For_Variations == "No" ? false : true);


	$UWCF_Colors = wp_get_post_terms($post_id, 'product_color');

	$WC_Color_Term_IDs = array();
	foreach ($UWCF_Colors as $Color) {
		$WC_Color_Term_IDs[] = (int) get_term_meta($Color->term_id, 'EWD_UWCF_WC_Term_ID',true);
	}

	wp_set_post_terms($post_id, $WC_Color_Term_IDs, 'pa_ewd_uwcf_colors');

	$UWCF_Sizes = wp_get_post_terms($post_id, 'product_size');
	
	$WC_Size_Term_IDs = array();
	foreach ($UWCF_Sizes as $Size) {
		$WC_Size_Term_IDs[] = (int) get_term_meta($Size->term_id, 'EWD_UWCF_WC_Term_ID',true);
	}

	wp_set_post_terms($post_id, $WC_Size_Term_IDs, 'pa_ewd_uwcf_sizes');

	$attributes = get_post_meta($post_id, '_product_attributes', true);
	if (!is_array($attributes)) {$attributes = array();}

	if (!in_array("pa_ewd_uwcf_colors", $attributes)) {$attributes['pa_ewd_uwcf_colors'] = array('name' => 'pa_ewd_uwcf_colors', 'value' => '', 'position' => sizeOf($attributes), 'is_visible' => $Colors_Visible, 'is_variation' => $Colors_Variation, 'is_taxonomy' => true);}
	if (!in_array("pa_ewd_uwcf_sizes", $attributes)) {$attributes['pa_ewd_uwcf_sizes'] = array('name' => 'pa_ewd_uwcf_sizes', 'value' => '', 'position' => sizeOf($attributes), 'is_visible' => $Sizes_Visible, 'is_variation' => $Sizes_Variation, 'is_taxonomy' => true);}

	update_post_meta($post_id, '_product_attributes', $attributes);
	update_option("EWD_UWCF_Update_Products", '');
}

?>