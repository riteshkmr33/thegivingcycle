<?php

/**
 * @package WordPress
 * @subpackage BuddyBoss MarketPlace
 */
if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly


if ( ! function_exists( 'bm_user_products' ) ) {
    function bm_user_products() {
        add_action( 'bp_template_content', 'bm_template_products' );
        bp_core_load_template( apply_filters( 'bm_user_products', 'members/single/plugins' ) );
    }
}

if ( ! function_exists( 'bm_template_products' ) ) {
    function bm_template_products() {
        bm_load_template('bm-products-page');
    }
}

if ( ! function_exists( 'bm_user_favorites' ) ) {
    function bm_user_favorites() {
        add_action( 'bp_template_content', 'bm_template_favorites' );
        bp_core_load_template( apply_filters( 'bm_user_favorites', 'members/single/plugins' ) );
    }
}

if ( ! function_exists( 'bm_template_favorites' ) ) {
    function bm_template_favorites() {
        bm_load_template('bm-favorites-page');
    }
}

if ( ! function_exists( 'bm_user_shops' ) ) {
    function bm_user_shops() {
        add_action( 'bp_template_content', 'bm_template_shops' );
        bp_core_load_template( apply_filters( 'bm_user_shops', 'members/single/plugins' ) );
    }
}

if ( ! function_exists( 'bm_template_shops' ) ) {
    function bm_template_shops() {
        bm_load_template('bm-favorite-shops-page');
    }
}

/**
 * Screen function to display the purchase history
 *
 * Template can be changed via the <code> bm_template_member_history</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since 	1.0
 * @uses	bp_core_load_template()
 * @uses	apply_filters()
 */
if ( ! function_exists( 'bm_screen_history' ) ) {
    function bm_screen_history()
    {
        add_action('bp_template_content', 'bm_template_history');
        bp_core_load_template(apply_filters('bm_template_member_history', 'members/single/plugins'));
    }
}

if ( ! function_exists( 'bm_template_history' ) ) {
    function bm_template_history() {
        bm_load_template('shop/member/history');
    }
}

/**
 * Screen function for tracking an order
 *
 * Template can be changed via the <code> bm_template_member_track_order</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since 	1.0
 * @uses	bp_core_load_template()
 * @uses	apply_filters()
 */

if ( ! function_exists( 'bm_screen_track_order' ) ) {
    function bm_screen_track_order()
    {
        add_action('bp_template_content', 'bm_template_track_order');
        bp_core_load_template(apply_filters('bm_template_member_track_order', 'members/single/plugins'));
    }
}

if ( ! function_exists( 'bm_template_track_order' ) ) {
    function bm_template_track_order() {
        bm_load_template('shop/member/track');
    }
}

/**
 * Register BuddyBoss Menu Page
 */
if ( !function_exists( 'register_buddyboss_menu_page' ) ) {

    function register_buddyboss_menu_page() {
        // Set position with odd number to avoid confict with other plugin/theme.
        add_menu_page( 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings', '', buddyboss_bm()->assets_url . '/images/logo.svg', 61.000129 );

        // To remove empty parent menu item.
        add_submenu_page( 'buddyboss-settings', 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings' );
        remove_submenu_page( 'buddyboss-settings', 'buddyboss-settings' );
    }

    add_action( 'admin_menu', 'register_buddyboss_menu_page' );
}

if ( ! function_exists( 'bm_load_template' ) ) {
    function bm_load_template($template)
    {
        $template .= '.php';
        if (file_exists(STYLESHEETPATH . '/bb-marketplace/' . $template))
            include_once(STYLESHEETPATH . '/bb-marketplace/' . $template);
        else if (file_exists(TEMPLATEPATH . '/bb-marketplace/' . $template))
            include_once(TEMPLATEPATH . '/bb-marketplace/' . $template);
        else {
            $template_dir = apply_filters('bm_load_template', buddyboss_bm()->templates_dir);
            include_once trailingslashit($template_dir) . $template;
        }
    }
}

if ( ! function_exists( 'bm_check_template' ) ) {
    function bm_check_template($template)
    {
        if ( strpos( $template, '.php' ) == false) {
            $template .= '.php';
        }

        if (file_exists(STYLESHEETPATH . '/bb-marketplace/' . $template))
            $path = STYLESHEETPATH . '/bb-marketplace/' . $template;
        else if (file_exists(TEMPLATEPATH . '/bb-marketplace/' . $template))
            $path = TEMPLATEPATH . '/bb-marketplace/' . $template;
        else {
            $template_dir = apply_filters('bm_check_template', buddyboss_bm()->templates_dir);
            $path = trailingslashit($template_dir) . $template;
        }
        return $path;
    }
}

/**
 * Output the tracked order
 *
 * @since 	1.0.8
 */
function  bm_output_tracking_order() {
    global $current_order;

    if( $current_order instanceof WC_Order ) :
        do_action( 'woocommerce_track_order', $current_order->get_id() );
        echo '<h3>'. __( 'Your Order', 'buddyboss-marketplace' ) .'<h3>';

        wc_get_template( 'order/tracking.php', array(
            'order' => $current_order
        ) );
    endif;
}
add_action( 'bm_after_track_body', 'bm_output_tracking_order' );

function bm_my_recent_orders_shortcode( $atts ) {

    $current_page    = bp_action_variable(0);
    $current_page    = empty( $current_page ) ? 1 : absint( $current_page );
    $customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array( 'customer' => get_current_user_id(), 'page' => $current_page, 'paginate' => true ) ) );

    return wc_get_template('myaccount/orders.php',
        array(
            'current_page' => absint( $current_page ),
            'customer_orders' => $customer_orders,
            'has_orders' => 0 < $customer_orders->total,
        )
    );


}
add_shortcode( 'bm_my_recent_orders', 'bm_my_recent_orders_shortcode' );

add_filter( 'woocommerce_get_endpoint_url', 'bm_my_recent_orders_pagination_url', 10, 4 );

function bm_my_recent_orders_pagination_url( $url, $endpoint, $value, $permalink  ) {

    if ( bm_is_buddypress_active() &&  'orders' == $endpoint ) {
        $user_domain = ( ! empty( $displayed_user_id ) ) ? bp_displayed_user_domain() : bp_loggedin_user_domain();
        $url = trailingslashit( $user_domain . 'orders/history/' . $value );
    }

    return $url;
}

add_action( 'wcv_pro_store_settings_saved', 'bm_update_user_location', 10, 1 );
add_action( 'wcv_save_pending_vendor',      'bm_update_user_location', 10, 1 );

/**
 * Save vendor's store latitude and longitude in database
 *
 * @param $vendor_id
 * @return bool
 */
function bm_update_user_location( $vendor_id ) {
    global $wpdb;

    $address1 	= get_user_meta( $vendor_id, '_wcv_store_address1', 	true );
    $address2 	= get_user_meta( $vendor_id, '_wcv_store_address2', 	true );
    $city	 	= get_user_meta( $vendor_id, '_wcv_store_city', 		true );
    $state	 	= get_user_meta( $vendor_id, '_wcv_store_state',		true );
    $country	= get_user_meta( $vendor_id, '_wcv_store_country', 	    true );
    $postcode	= get_user_meta( $vendor_id, '_wcv_store_postcode', 	true );

    $address =  $address1 .' ' .$address2 .' '. $city .' '. $state .' '. $country. ' '. $postcode;

    $all_settings   = get_option('widget_buddyboss_widget_location_filter');
    end($all_settings);
    $_settings      = prev($all_settings);

    $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=' . rawurlencode($address) . '&key=' . $_settings['api_key'];

    if ( !$response = wp_remote_get( $url ) ) {
        return false;
    }
    if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return false;
    }
    if ( '' === $response_body = wp_remote_retrieve_body( $response ) ) {
        return false;
    }

    $data =json_decode( $response_body, true );

    if ( isset( $data['results'][0] ) ) {

        $lat = $data['results'][0]['geometry']['location']['lat'];
        $lng = $data['results'][0]['geometry']['location']['lng'];

        $sql = "INSERT INTO {$wpdb->prefix}bm_user_location (user_id, lat, lng) VALUES (%d,  %f, %f) ON DUPLICATE KEY UPDATE lat = %f, lng = %f";
        $sql = $wpdb->prepare( $sql, $vendor_id, $lat, $lng, $lat, $lng );
        $wpdb->query($sql);

        return true;
    }
}

add_action( 'woocommerce_product_query', 'bm_shop_by_location', 10, 1 );

/**
 *
 * @param $query
 * @return mixed
 */
function bm_shop_by_location( $query ) {
    global $wpdb;

    if( !isset( $_GET['formatted_address'] ) || empty( $_GET['lat'] ) || empty( $_GET['lng'] ) )
        return;

    if ( is_admin() || !$query->is_main_query() ) {
        return;
    }

    $all_settings   = get_option('widget_buddyboss_widget_location_filter');
	end($all_settings);
	$_settings      = prev($all_settings);

    $u_lat  = $_GET['lat'];
    $u_lng  = $_GET['lng'];
    $radius_search = isset( $_settings['radius_search'] ) ? $_settings['radius_search'] : '';
    $radius = isset( $_settings['radius'] ) ? $_settings['radius'] : '1000';

    if ( 'on' === $radius_search ) {

		// Source: https://stackoverflow.com/questions/29553895/querying-mysql-for-latitude-and-longitude-coordinates-that-are-within-a-given-mi
		// Spherical Law of Cosines Formula
		$query_vendor = "SELECT user_id  FROM {$wpdb->prefix}bm_user_location WHERE ( 3959 * acos( cos( radians({$u_lat}) ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians({$u_lng}) ) + sin( radians({$u_lat}) ) * sin(radians(lat)) ) )  < {$radius}";

		$vendors_in = $wpdb->get_col( $query_vendor );

		if ( ! empty( $vendors_in ) ) {
			$query->set('author__in', $vendors_in );
		} else {
			$query->set('author__in', array(0) );
		}

	} else {

		if ( isset( $_REQUEST['formatted_address'] ) ) {
			//Make address reverse 3. Country, 2. State, 1. City
			$formatted_address = array_reverse( explode( ', ', $_REQUEST['formatted_address'] ) );
		}

		if ( ! empty( $_REQUEST['country'][0] ) //Country Shorted name
			&& ! empty( $_REQUEST['country'][1] ) //Country long name
		) {

			$user_query = "SELECT user_id FROM {$wpdb->usermeta} WHERE  meta_key = '_wcv_store_country' AND
                            ( LOWER( meta_value ) =  LOWER( '". $_REQUEST['country'][0] ."') 
                             OR  LOWER( meta_value ) = LOWER( '". $_REQUEST['country'][1] ."')";

			$country_code = array_search( $formatted_address[0], WC()->countries->countries );
			$user_query .= " OR LOWER( meta_value ) = LOWER( '". $country_code ."') ";

			$user_query .= ")";

			$country_users = $users = $wpdb->get_col( $user_query );

			//0 users fallback
			if ( empty( $users ) ) {
				$country_users = $users = array( 0 );
			}

			if ( ! empty( $_REQUEST['state'][0] ) //State short name
				&& ! empty( $_REQUEST['state'][1] ) //State long name
			)
			{
				$user_query = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '_wcv_store_state' AND
                              ( LOWER( meta_value ) = LOWER( '". $_REQUEST['state'][0] ."')
                               OR LOWER( meta_value ) = LOWER( '". $_REQUEST['state'][1] ."')";

				$state_code = array_search( $formatted_address[1], WC()->countries->states[$country_code] );

				$user_query .= " OR LOWER( meta_value ) = LOWER( '". $state_code ."') ";

				$user_query .= ")";

				$user_str = implode( ',', $users );
				$user_query .= " AND user_id IN ({$user_str}) ";

				$state_users = $users = $wpdb->get_col( $user_query );

			}

			//0 users fallback
			if ( empty( $users ) ) {
				$state_users = $users = array( 0 );
			}

			if ( ! empty( $_REQUEST['city'][0] ) //City short name
				&& ! empty( $_REQUEST['city'][1] ) //City long name
			)
			{
				$user_query = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '_wcv_store_city' AND
                              ( LOWER( meta_value ) = LOWER( '". $_REQUEST['city'][0] ."' )
                               OR LOWER( meta_value ) = LOWER( '". $_REQUEST['city'][1] ."' )";

				//City conventional name
				if ( ! empty( $formatted_address[2] ) ) {
					$user_query .= " OR LOWER( meta_value ) = LOWER( '". $formatted_address[2] ."')";
				}

				$user_query .= ")";

				//merge users from country and state
				$users = array_merge( $country_users, $state_users );

				//Include users from state
				$user_str = implode( ',', $users );
				$user_query .= " AND user_id IN ({$user_str}) ";

				$users = $wpdb->get_col( $user_query );
			}

			//0 users fallback
			if ( empty( $users ) ) {
				$users = array( 0 );
			}

		}

		//All user ids found in location search
		if ( ! empty( $users ) ) {
			$author_in = $users;
		}

		$query->set('author__in', $author_in );
	}
}

/**
 * Add a new column, for favorite count, in the product list table.
 * @param array $columns
 * @return array
 */
function bm_wcv_product_table_columns( $columns ){
    if( !empty( $columns ) ){
        $new_columns = array();

        $new_column_number = 5;
        $i = 1;

        foreach( $columns as $k=>$l ){
            if( $i == $new_column_number ){
                $new_columns['favorites'] = '<i class="fa fa-heart"></i>';
            }

            $new_columns[$k] = $l;
            $i++;
        }

        $columns = $new_columns;
    }
    return $columns;
}
add_filter( 'wcv_product_table_columns', 'bm_wcv_product_table_columns' );

/**
 * Show the data for the newly added column above.
 *
 * @param array $rows
 * @return array
 */
function bm_wcv_product_table_rows( $rows ){
    if( !empty( $rows ) ){
        $products_favorited_count = get_option('products_favorited_count');

        foreach( $rows as $row ){
            $row->favorites = isset( $products_favorited_count[$row->ID] ) ? $products_favorited_count[$row->ID] : 0;
        }
    }
    return $rows;
}
add_filter( 'wcv_product_table_rows', 'bm_wcv_product_table_rows' );

add_action( 'wcv_pro_store_settings_saved', 'bm_update_vendor_social_links', 10, 1 );

/**
 * Update vendor's social filed which are displaying on a member profile page
 * @param $vendor_id
 */
function bm_update_vendor_social_links( $vendor_id ) {

	$twitter_username 	= ( isset( $_POST[ '_wcv_twitter_username' ] ) ) 	? sanitize_text_field( $_POST[ '_wcv_twitter_username' ] )		: '';
	$instagram_username = ( isset( $_POST[ '_wcv_instagram_username' ] ) ) 	? sanitize_text_field( $_POST[ '_wcv_instagram_username' ] )	: '';
	$facebook_url 		= ( isset( $_POST[ '_wcv_facebook_url' ] ) ) 		? sanitize_text_field( $_POST[ '_wcv_facebook_url' ] )			: '';
	$linkedin_url 		= ( isset( $_POST[ '_wcv_linkedin_url' ] ) ) 		? sanitize_text_field( $_POST[ '_wcv_linkedin_url' ] )			: '';
	$youtube_url 		= ( isset( $_POST[ '_wcv_youtube_url' ] ) ) 		? sanitize_text_field( $_POST[ '_wcv_youtube_url' ] )			: '';
	$pinterest_url 		= ( isset( $_POST[ '_wcv_pinterest_url' ] ) ) 		? sanitize_text_field( $_POST[ '_wcv_pinterest_url' ] )		: '';
	$googleplus_url 	= ( isset( $_POST[ '_wcv_googleplus_url' ] ) ) 		? sanitize_text_field( $_POST[ '_wcv_googleplus_url' ] )		: '';
	$social_links = array();

	// Twitter Username
	if ( isset( $twitter_username ) && '' !== $twitter_username ) {
		$social_links['twitter'] = 'https://twitter.com/'.$twitter_username;
	}

	//Instagram Username
	if ( isset( $instagram_username ) && '' !== $instagram_username ) {
		$social_links['instagram'] = 'https://www.instagram.com/'.$instagram_username;
	}
	// Facebook URL
	if ( isset( $facebook_url ) && '' !== $facebook_url ) {
		$social_links['facebook'] = $facebook_url;
	}

	// LinkedIn URL
	if ( isset( $linkedin_url ) && '' !== $linkedin_url ) {
		$social_links['linkedin'] = $linkedin_url;
	}

	// YouTube URL
	if ( isset( $youtube_url ) && '' !== $youtube_url ) {
		$social_links['youtube'] = $youtube_url;
	}

	// Pinterest URL
	if ( isset( $pinterest_url ) && '' !== $pinterest_url ) {
		$social_links['pinterest'] = $pinterest_url;
	}

	// Google+ URL
	if ( isset( $googleplus_url ) && '' !== $googleplus_url ) {
		$social_links['google-plus'] =	$googleplus_url;
	}

	$default_links = (array) get_user_meta( $vendor_id, 'user_social_links',true );

	$user_social_links = wp_parse_args( $social_links, $default_links );

	update_user_meta( $vendor_id, 'user_social_links', $user_social_links );
}

add_filter( 'onesocial_login_redirect', 'bm_vendor_login_redirect', 10, 2 );

/**
 * Redirect vendor logins to the specified page from OneSocial login overlay
 *
 * @since 1.5.0
 */
function bm_vendor_login_redirect( $redirect_to, $user ) {

	if ( WCV_Vendors::is_vendor( $user->ID ) ) {
		$redirect_to = get_permalink( get_option( 'wcvendors_dashboard_page_id' ) );
	}

	return $redirect_to;

} // vendor_login_redirect()
