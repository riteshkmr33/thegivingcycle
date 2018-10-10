<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Is see BuddyPress is installed and active?
 *
 *
 * @return boolean True if BuddyPress is active, false if not.
 */
function bm_is_buddypress_active() {

    // Ensure get_plugins function is loaded
    if ( ! function_exists( 'get_plugins' ) ) {
        include ABSPATH . '/wp-admin/includes/plugin.php';
    }

    // Single site.
    if ( is_plugin_active( 'buddypress/bp-loader.php' ) )
        return true;

    // Network active.
    if ( is_plugin_active_for_network( 'buddypress/bp-loader.php' ) )
        return true;

    // Nope.
    return false;
}

/**
 * Return the domain for the passed user
 *
 * @param $user_id
 * @return mixed|void
 */
function bm_get_user_domain($user_id ) {

    if ( empty( $user_id ) ) {
        return;
    }

    if ( bm_is_buddypress_active() ) {
        $domain = bp_core_get_user_domain( $user_id );
    } else {
        $domain = WCV_Vendors::get_vendor_shop_page( $user_id );
    }

    /**
     * Filters the domain for the passed user.
     *
     * @param string $domain        Domain for the passed user.
     * @param int    $user_id       ID of the passed user.
     */
    return apply_filters( 'bm_get_user_domain', $domain, $user_id );
}

/**
 * Fetch the display name for a user.
 *
 * @param $user_id
 * @return bool|string
 */
function bm_get_user_displayname ($user_id ) {

    if ( bm_is_buddypress_active() ) {
       return bp_core_get_user_displayname( $user_id );
    } else {
        $userdata = get_userdata( $user_id );
        return $userdata->display_name;
    }
}

/**
 *  Get all orders ids for a vendor
 *
 * @param $vendor_id
 * @return array
 */
function bm_get_order_ids_by_vendor( $vendor_id ) {
    global $wpdb;

    $sql = "SELECT DISTINCT( order_id ) order_id FROM {$wpdb->prefix}pv_commission WHERE vendor_id = {$vendor_id} AND status != 'reversed'";

    return $wpdb->get_col( $sql );
}

/**
 * Check whether user is vendor or not
 * @param $user_id
 * @return bool
 */
function bm_is_vendor_user( $user_id ) {
    $user = get_userdata( $user_id );

    $role      = !empty( $user->roles ) ? array_shift( $user->roles ) : false;
    $is_vendor = ( $role == 'vendor' );

    return $is_vendor;
}

if ( ! function_exists( 'bm_remove_anonymous_object_filter' ) ) {
	/**
	 * Remove an anonymous object filter.
	 *
	 * @param  string $tag    Hook name.
	 * @param  string $class  Class name
	 * @param  string $method Method name
	 * @return void
	 */
	function bm_remove_anonymous_object_filter( $tag, $class, $method ) {

		$filters = array();

		if ( isset( $GLOBALS['wp_filter'][ $tag ] ) ) {
			$filters = $GLOBALS['wp_filter'][ $tag ];
		}

		if ( empty ( $filters ) ) {
			return;
		}

		foreach ( $filters as $priority => $filter )
		{
			foreach ( $filter as $identifier => $function )
			{
				if ( is_array( $function)
					and is_a( $function['function'][0], $class )
					and $method === $function['function'][1]
				)
				{
					remove_filter(
						$tag,
						array ( $function['function'][0], $method ),
						$priority
					);
				}
			}
		}
	}
}