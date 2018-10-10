<?php
function EWD_UWCF_Sort_By_Order($query) {
	if (is_admin() and isset($_GET['taxonomy']) and $_GET['taxonomy'] == 'product_color' and !isset($_GET['orderby'])) {
		$query->set( 'meta_key', 'EWD_UWCF_Term_Order' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'EWD_UWCF_Sort_By_Order' );

?>