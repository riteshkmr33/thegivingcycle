<?php

function EWD_UWCF_Update_Color_Order() {
	$IDs = json_decode(stripslashes($_POST['IDs']));
	if (!is_array($IDs)) {$IDs = array();}

	foreach ($IDs as $Order => $term_id) {
		update_term_meta($term_id, 'EWD_UWCF_Term_Order', $Order);
	}

}
add_action('wp_ajax_ewd_uwcf_update_color_order', 'EWD_UWCF_Update_Color_Order');

function EWD_UWCF_Update_Size_Order() {
	$IDs = json_decode(stripslashes($_POST['IDs']));
	if (!is_array($IDs)) {$IDs = array();}

	foreach ($IDs as $Order => $term_id) {
		update_term_meta($term_id, 'EWD_UWCF_Term_Order', $Order);
	}

}
add_action('wp_ajax_ewd_uwcf_update_size_order', 'EWD_UWCF_Update_Size_Order');


function EWD_UWCF_Hide_Review_Ask(){   
    $Ask_Review_Date = sanitize_text_field($_POST['Ask_Review_Date']);

    update_option('EWD_UWCF_Ask_Review_Date', time()+3600*24*$Ask_Review_Date);

    die();
}
add_action('wp_ajax_ewd_uwcf_hide_review_ask','EWD_UWCF_Hide_Review_Ask');

