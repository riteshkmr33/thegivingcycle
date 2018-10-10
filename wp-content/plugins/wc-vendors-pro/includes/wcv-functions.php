<?php
/**
 * Active plugins
 */
if ( ! function_exists( 'get_active_plugins') ){
	function get_active_plugins(){
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() ) $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		return $active_plugins;
	}
}

/**
 * WooCommerce Detection
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		$active_plugins = get_active_plugins();
		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}
}

/**
 * WC Vendors Detection
 */
if ( ! function_exists( 'is_wcvendors_active' ) ) {
	function is_wcvendors_active() {
		$active_plugins = get_active_plugins();
		return in_array( 'wc-vendors/class-wc-vendors.php', $active_plugins ) || array_key_exists( 'wc-vendors/class-wc-vendors.php', $active_plugins );
	}
}

/**
*	WC Vendors 2.0.0
*/
if ( ! function_exists( 'is_wcvendors_2_0_0' ) ) {
	function is_wcvendors_2_0_0() {
		if ( class_exists( 'WC_Vendors' ) ){
			error_log( version_compare( WCV_VERSION, '2.0.0', '<') );
			return version_compare( WCV_VERSION, '2.0.0', '<');
		}
	}
}


/**
 * WooCommerce Required Notice
 */
if ( ! function_exists( 'woocommerce_required_notice' ) ) {
	function woocommerce_required_notice() {
		echo '<div class="error"><p><strong>' . __( 'WooCommerce not found. WC Vendors Pro requires a minimum of WooCommerce v3.3.0.', 'wcvendors-pro' ) . '</strong></p></div>';
	}
}

/**
 * WCVendors Required Notice
 */
if ( ! function_exists( 'wcvendors_required_notice' ) ) {
	function wcvendors_required_notice() {
		echo '<div class="error"><p><strong>' . __( 'WC Vendors not found. WC Vendors Pro requires a minimum of WC Vendors v2.0.0', 'wcvendors-pro' ) . '</strong></p></div>';
	}
}


/**
 * WCVendors 2.0.0 Required Notice
 */
if ( ! function_exists( 'wcvendors_2_required_notice' ) ) {
	function wcvendors_2_required_notice() {
		echo '<div class="error"><p>' . __( '<b>WC Vendors Pro requires a minimum of WC Vendors v2.0.0', 'wcvendors-pro' ) . '</p></div>';
	}
}
