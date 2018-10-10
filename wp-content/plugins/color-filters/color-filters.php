<?php

class NM_Color_Filters {


	/*
     * Notice message when WooCommerce plugin is not activated
     */
	function notice_no_woocommerce() {
	?>
        <div class="message error"><p><?php printf( __( 'Color Filters by <a href="%s" target="_blank">Etoile Web Design</a> is enabled but not effective. It requires <a href="%s" target="_blank">WooCommerce</a> in order to work.', 'elm' ), 'https://www.etoilewebdesign.com', 'http://www.woothemes.com/woocommerce/' ); ?></p></div>
    <?php
	}

	/**
	 * Front-end display CSS.
	 *
	 */
	function plugin_scripts() {
		wp_enqueue_style( 'color-filters', CF_PLUGIN_URL . '/assets/css/color-filters.css' );
	}
	
	
		
	
}

