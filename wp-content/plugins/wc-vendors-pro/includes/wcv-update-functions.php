<?php
/**
 * WC Vendors Pro Updates
 *
 * Functions for updating data, used by the background updater.
 *
 * @package WCVendors Pro/Functions
 * @version 1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Map WC Vendors Pro settings to WC Vendors version two settings
*
* @since 1.5.0
*/
add_filter( 'wcvendors_settings_mappings', 'wcvendors_pro_get_settings_mapping' );
function wcvendors_pro_get_settings_mapping( $settings ){
	$wcvendors_pro_settings_mappings = wcvendors_pro_settings_mapping();
	return array_merge( $settings, $wcvendors_pro_settings_mappings );
}

function wcvendors_pro_settings_mapping(){

	return $wcvendors_pro_settings_mappings = array(
		'dashboard_page_id' 					=> 'wcvendors_dashboard_page_id',
		'vendor_store_header_type' 				=> 'wcvendors_vendor_store_header_type',
		'store_shop_headers' 					=> 'wcvendors_store_shop_headers',
		'store_single_headers' 					=> 'wcvendors_store_single_headers',
		'disable_wp_admin_vendors' 				=> 'wcvendors_disable_wp_admin_vendors',
		'vendor_dashboard_notice' 				=> 'wcvendors_vendor_dashboard_notice',
		'allow_form_markup' 					=> 'wcvendors_allow_form_markup',
		'single_product_tools' 					=> 'wcvendors_single_product_tools',
		'product_management_cap' 				=> 'wcvendors_product_management_cap',
		'order_management_cap' 					=> 'wcvendors_order_management_cap',
		'shop_coupon_management_cap' 			=> 'wcvendors_shop_coupon_management_cap',
		'settings_management_cap' 				=> 'wcvendors_settings_management_cap',
		'ratings_management_cap' 				=> 'wcvendors_ratings_management_cap',
		'shipping_management_cap' 				=> 'wcvendors_shipping_management_cap',
		'view_store_cap'	 					=> 'wcvendors_view_store_cap',
		'delete_product_cap' 					=> 'wcvendors_capability_product_delete',
		'duplicate_product_cap'	 				=> 'wcvendors_capability_product_duplicate',
		'can_edit_approved_products' 			=> 'wcvendors_capability_products_approved',
		'dashboard_date_range' 					=> 'wcvendors_dashboard_date_range',
		'orders_sales_range' 					=> 'wcvendors_orders_sales_range',
		'products_per_page' 					=> 'wcvendors_products_per_page',
		'coupons_per_page' 						=> 'wcvendors_coupons_per_page',
		'hide_order_customer_name' 				=> 'wcvendors_capability_order_customer_name',
		'hide_order_customer_shipping_address' 	=> 'wcvendors_capability_order_customer_shipping',
		'hide_order_customer_billing_address' 	=> 'wcvendors_capability_order_customer_billling',
		'hide_order_customer_phone' 			=> 'wcvendors_capability_order_customer_phone',
		'hide_order_view_details' 				=> 'wcvendors_hide_order_view_details',
		'hide_order_shipping_label' 			=> 'wcvendors_hide_order_shipping_label',
		'hide_order_order_note' 				=> 'wcvendors_hide_order_order_note',
		'hide_order_tracking_number' 			=> 'wcvendors_hide_order_tracking_number',
		'hide_order_mark_shipped' 				=> 'wcvendors_hide_order_mark_shipped',
		'vendor_product_trash' 					=> 'wcvendors_vendor_product_trash',
		'vendor_coupon_trash' 					=> 'wcvendors_vendor_coupon_trash',
		'default_store_banner_src' 				=> 'wcvendors_default_store_banner_src',
		'verified_vendor_label' 				=> 'wcvendors_verified_vendor_label',
		'disable_select2'						=> 'wcvendors_disable_select2',
		'feedback_page_id' 						=> 'wcvendors_feedback_page_id',
		'vendor_ratings_label' 					=> 'wcvendors_vendor_ratings_label',
		'feedback_system' 						=> 'wcvendors_feedback_system',
		'feedback_display' 						=> 'wcvendors_feedback_display',
		'feedback_sort_order' 					=> 'wcvendors_feedback_sort_order',
		'feedback_order_status' 				=> 'wcvendors_feedback_order_status',
		'commission_coupon_action' 				=> 'wcvendors_commission_coupon_action',
		'commission_type' 						=> 'wcvendors_commission_type',
		'commission_percent' 					=> 'wcvendors_commission_percent',
		'commission_amount' 					=> 'wcvendors_commission_amount',
		'commission_fee' 						=> 'wcvendors_commission_fee',
		'product_form_template' 				=> 'wcvendors_product_form_template',
		'hide_product_basic' 					=> 'wcvendors_hide_product_basic_{field}',
		'hide_product_media' 					=> 'wcvendors_hide_product_media_{field}',
		'hide_product_general'	 				=> 'wcvendors_hide_product_general_{field}',
		'hide_product_inventory' 				=> 'wcvendors_hide_product_inventory_{field}',
		'hide_product_shipping' 				=> 'wcvendors_hide_product_shipping_{field}',
		'hide_product_upsells' 					=> 'wcvendors_hide_product_upsells_{field}',
		'hide_product_variations' 				=> 'wcvendors_hide_product_variations_{field}',
		'required_product_basic' 				=> 'wcvendors_required_product_basic_{field}',
		'required_product_media' 				=> 'wcvendors_required_product_media_{field}',
		'required_product_general' 				=> 'wcvendors_required_product_general_{field}',
		'required_product_inventory' 			=> 'wcvendors_required_product_inventory_{field}',
		'required_product_shipping' 			=> 'wcvendors_required_product_shipping_{field}',
		'required_product_upsells' 				=> 'wcvendors_required_product_upsells_{field}',
		'save_product_redirect' 				=> 'wcvendors_save_product_redirect',
		'product_form_cap' 						=> 'wcvendors_product_form_cap',
		'category_display' 						=> 'wcvendors_category_display',
		'hide_categories_list' 					=> 'wcvendors_hide_categories_list',
		'category_limit' 						=> 'wcvendors_category_limit',
		'tag_display' 							=> 'wcvendors_tag_display',
		'tag_separator'	 						=> 'wcvendors_tag_separator',
		'file_display' 							=> 'wcvendors_file_display',
		'hide_attributes_list' 					=> 'wcvendors_hide_attributes_list',
		'vendor_image_prefix' 					=> 'wcvendors_vendor_image_prefix',
		'product_max_gallery_count' 			=> 'wcvendors_product_max_gallery_count',
		'product_max_image_width' 				=> 'wcvendors_product_max_image_width',
		'product_max_image_height' 				=> 'wcvendors_product_max_image_height',
		'product_min_image_width' 				=> 'wcvendors_product_min_image_width',
		'product_min_image_height' 				=> 'wcvendors_product_min_image_height',
		'hide_settings_general' 				=> 'wcvendors_hide_settings_general',
		'hide_settings_store' 					=> 'wcvendors_hide_settings_store',
		'hide_settings_payment' 				=> 'wcvendors_hide_settings_payment',
		'hide_settings_branding' 				=> 'wcvendors_hide_settings_branding',
		'hide_settings_shipping' 				=> 'wcvendors_hide_settings_shipping',
		'hide_settings_social' 					=> 'wcvendors_hide_settings_social',
		'hide_signup_general' 					=> 'wcvendors_hide_signup_general',
		'hide_signup_store' 					=> 'wcvendors_hide_signup_store',
		'hide_signup_payment' 					=> 'wcvendors_hide_signup_payment',
		'hide_signup_branding' 					=> 'wcvendors_hide_signup_branding',
		'hide_signup_shipping' 					=> 'wcvendors_hide_signup_shipping',
		'hide_signup_social' 					=> 'wcvendors_hide_signup_social',
		'vendor_signup_notice' 					=> 'wcvendors_vendor_signup_notice',
		'vendor_pending_notice' 				=> 'wcvendors_vendor_pending_notice',
	);

}
/**
* Migrate Pro to version 1.5.0
*/
function wcv_migrate_pro_settings(){

$version_one = get_option( 'wc_prd_vendor_options', null );
$mappings = wcvendors_pro_settings_mapping();

if ( is_null( $version_one ) ) return;

foreach ( $version_one as $setting => $value ) {

	// if ( array_key_exists( $setting, $mappings ) ){

		$value = maybe_unserialize( $value );

		if ( $setting == 'hide_product_basic' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_basic_description', $value[ 'description' ] );
			update_option( 'wcvendors_hide_product_basic_short_description', $value[ 'short_description'] );
			update_option( 'wcvendors_hide_product_basic_categories', $value[ 'categories' ] );
			update_option( 'wcvendors_hide_product_basic_tags', $value[ 'tags' ] );
			update_option( 'wcvendors_hide_product_basic_attributes', $value[ 'attributes' ] );

		} elseif ( $setting == 'hide_product_media' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_media_featured', $value[ 'featured' ] );
			update_option( 'wcvendors_hide_product_media_gallery', $value[ 'gallery' ] );

		} elseif ( $setting == 'hide_product_general' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_general_sku', $value[ 'sku' ] );
			update_option( 'wcvendors_hide_product_general_private_listing', $value[ 'private_listing' ] );
			update_option( 'wcvendors_hide_product_general_external_url', $value[ 'external_url' ] );
			update_option( 'wcvendors_hide_product_general_button_text', $value[ 'button_text' ] );
			update_option( 'wcvendors_hide_product_general_price', $value[ 'price' ] );
			update_option( 'wcvendors_hide_product_general_sale_price', $value[ 'sale_price' ] );
			update_option( 'wcvendors_hide_product_general_tax', $value[ 'tax' ] );
			update_option( 'wcvendors_hide_product_general_download_files', $value[ 'download_files' ] );
			update_option( 'wcvendors_hide_product_general_download_file_url', $value[ 'download_file_url' ] );
			update_option( 'wcvendors_hide_product_general_download_limit', $value[ 'download_limit' ] );
			update_option( 'wcvendors_hide_product_general_download_expiry', $value[ 'download_expiry' ] );
			update_option( 'wcvendors_hide_product_general_download_type', $value[ 'download_type' ] );

		} elseif ( $setting == 'hide_product_inventory' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_inventory_manage_inventory', $value[ 'manage_inventory' ] );
			update_option( 'wcvendors_hide_product_inventory_stock_qty', $value[ 'stock_qty' ] );
			update_option( 'wcvendors_hide_product_inventory_backorders', $value[ 'backorders' ] );
			update_option( 'wcvendors_hide_product_inventory_stock_status', $value[ 'stock_status' ] );
			update_option( 'wcvendors_hide_product_inventory_sold_individually', $value[ 'sold_individually' ] );

		} elseif ( $setting == 'hide_product_shipping' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_shipping_weight', $value[ 'weight' ] );
			update_option( 'wcvendors_hide_product_shipping_handling_fee', $value[ 'handling_fee' ] );
			update_option( 'wcvendors_hide_product_shipping_max_charge', $value[ 'max_charge' ] );
			update_option( 'wcvendors_hide_product_shipping_free_shipping_order', $value[ 'free_shipping_order' ] );
			update_option( 'wcvendors_hide_product_shipping_free_shipping_product', $value[ 'free_shipping_product' ] );
			update_option( 'wcvendors_hide_product_shipping_dimensions', $value[ 'dimensions' ] );
			update_option( 'wcvendors_hide_product_shipping_shipping_class', $value[ 'shipping_class' ] );

		} elseif ( $setting == 'hide_product_upsells' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_upsells_up_sells', $value[ 'up_sells' ] );
			update_option( 'wcvendors_hide_product_upsells_crosssells', $value[ 'crosssells' ] );
			update_option( 'wcvendors_hide_product_upsells_grouped_products', $value[ 'grouped_products' ] );

		} elseif ( $setting == 'hide_product_variations' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_product_variations_featured', $value[ 'featured' ] );
			update_option( 'wcvendors_hide_product_variations_sku', $value[ 'sku' ] );
			update_option( 'wcvendors_hide_product_variations_enabled', $value[ 'enabled' ] );
			update_option( 'wcvendors_hide_product_variations_downloadable', $value[ 'downloadable' ] );
			update_option( 'wcvendors_hide_product_variations_virtual', $value[ 'virtual' ] );
			update_option( 'wcvendors_hide_product_variations_manage_stock', $value[ 'manage_stock' ] );
			update_option( 'wcvendors_hide_product_variations_sale_price', $value[ 'sale_price' ] );
			update_option( 'wcvendors_hide_product_variations_stock_qty', $value[ 'stock_qty' ] );
			update_option( 'wcvendors_hide_product_variations_allow_backorders', $value[ 'allow_backorders' ] );
			update_option( 'wcvendors_hide_product_variations_stock_status', $value[ 'stock_status' ] );
			update_option( 'wcvendors_hide_product_variations_weight', $value[ 'weight' ] );
			update_option( 'wcvendors_hide_product_variations_dimensions', $value[ 'dimensions' ] );
			update_option( 'wcvendors_hide_product_variations_shipping_class', $value[ 'shipping_class' ] );
			update_option( 'wcvendors_hide_product_variations_tax_class', $value[ 'tax_class' ] );
			update_option( 'wcvendors_hide_product_variations_description', $value[ 'description' ] );
			update_option( 'wcvendors_hide_product_variations_download_files', $value[ 'download_files' ] );
			update_option( 'wcvendors_hide_product_variations_download_limit', $value[ 'download_limit' ] );
			update_option( 'wcvendors_hide_product_variations_download_expiry', $value[ 'download_expiry' ] );

		} elseif ( $setting == 'hide_settings_general' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_settings_tab_payment', $value[ 'payment' ] );
			update_option( 'wcvendors_hide_settings_tab_branding', $value[ 'branding' ] );
			update_option( 'wcvendors_hide_settings_tab_shipping', $value[ 'shipping' ] );
			update_option( 'wcvendors_hide_settings_tab_social', $value[ 'social' ] );

		} elseif ( $setting == 'hide_settings_store' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_settings_store_description', $value[ 'pv_shop_description' ] );
			update_option( 'wcvendors_hide_settings_store_seller_info', $value[ 'pv_seller_info' ] );
			update_option( 'wcvendors_hide_settings_store_company_url', $value[ '_wcv_company_url' ] );
			update_option( 'wcvendors_hide_settings_store_phone', $value[ '_wcv_store_phone' ] );
			update_option( 'wcvendors_hide_settings_store_address', $value[ 'store_address' ] );
			update_option( 'wcvendors_hide_settings_store_vacation_mode', $value[ 'vacation_mode' ] );

		} elseif ( $setting == 'hide_settings_payment' && ! empty( $value ) ){
			update_option( 'wcvendors_hide_settings_payment_paypal', $value[ 'paypal' ] );

		} elseif ( $setting == 'hide_settings_branding' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_settings_branding_store_banner', $value[ 'store_banner' ] );
			update_option( 'wcvendors_hide_settings_branding_store_icon', $value[ 'store_icon' ] );

		} elseif ( $setting == 'hide_settings_shipping' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_settings_shipping_handling_fee', $value[ 'handling_fee' ] );
			update_option( 'wcvendors_hide_settings_shipping_min_charge', $value[ 'min_charge' ] );
			update_option( 'wcvendors_hide_settings_shipping_max_charge', $value[ 'max_charge' ] );
			update_option( 'wcvendors_hide_settings_shipping_max_charge_product', $value[ 'max_charge_product' ] );
			update_option( 'wcvendors_hide_settings_shipping_free_shipping_order', $value[ 'free_shipping_order' ] );
			update_option( 'wcvendors_hide_settings_shipping_free_shipping_product', $value[ 'free_shipping_product' ] );
			update_option( 'wcvendors_hide_settings_shipping_shipping_policy', $value[ 'shipping_policy' ] );
			update_option( 'wcvendors_hide_settings_shipping_return_policy', $value[ 'return_policy' ] );

		} elseif ( $setting == 'hide_settings_social' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_settings_social_twitter', $value[ 'twitter' ] );
			update_option( 'wcvendors_hide_settings_social_instagram', $value[ 'instagram' ] );
			update_option( 'wcvendors_hide_settings_social_facebook', $value[ 'facebook' ] );
			update_option( 'wcvendors_hide_settings_social_linkedin', $value[ 'linkedin' ] );
			update_option( 'wcvendors_hide_settings_social_youtube', $value[ 'youtube' ] );
			update_option( 'wcvendors_hide_settings_social_pinterest', $value[ 'pinterest' ] );
			update_option( 'wcvendors_hide_settings_social_google_plus', $value[ 'google_plus' ] );
			update_option( 'wcvendors_hide_settings_social_snapchat', $value[ 'snapchat' ] );

		} elseif ( $setting == 'hide_signup_general' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_signup_tab_payment', $value[ 'payment' ] );
			update_option( 'wcvendors_hide_signup_tab_branding', $value[ 'branding' ] );
			update_option( 'wcvendors_hide_signup_tab_shipping', $value[ 'shipping' ] );
			update_option( 'wcvendors_hide_signup_tab_social', $value[ 'social' ] );

		} elseif ( $setting == 'hide_signup_store' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_signup_store_description', $value[ 'pv_shop_description' ] );
			update_option( 'wcvendors_hide_signup_store_seller_info', $value[ 'pv_seller_info' ] );
			update_option( 'wcvendors_hide_signup_store_company_url', $value[ '_wcv_company_url' ] );
			update_option( 'wcvendors_hide_signup_store_phone', $value[ '_wcv_store_phone' ] );
			update_option( 'wcvendors_hide_signup_store_address', $value[ 'store_address' ] );
			update_option( 'wcvendors_hide_signup_store_vacation_mode', $value[ 'vacation_mode' ] );

		} elseif ( $setting == 'hide_signup_payment' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_signup_payment_paypal', $value[ 'paypal' ] );

		} elseif ( $setting == 'hide_signup_shipping' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_signup_shipping_handling_fee', $value[ 'handling_fee' ] );
			update_option( 'wcvendors_hide_signup_shipping_min_charge', $value[ 'min_charge' ] );
			update_option( 'wcvendors_hide_signup_shipping_max_charge', $value[ 'max_charge' ] );
			update_option( 'wcvendors_hide_signup_shipping_max_charge_product', $value[ 'max_charge_product' ] );
			update_option( 'wcvendors_hide_signup_shipping_free_shipping_order', $value[ 'free_shipping_order' ] );
			update_option( 'wcvendors_hide_signup_shipping_free_shipping_product', $value[ 'free_shipping_product' ] );
			update_option( 'wcvendors_hide_signup_shipping_shipping_policy', $value[ 'shipping_policy' ] );
			update_option( 'wcvendors_hide_signup_shipping_return_policy', $value[ 'return_policy' ] );

		} elseif ( $setting == 'hide_signup_social' && ! empty( $value ) ){

			update_option( 'wcvendors_hide_signup_social_twitter', $value[ 'twitter' ] );
			update_option( 'wcvendors_hide_signup_social_instagram', $value[ 'instagram' ] );
			update_option( 'wcvendors_hide_signup_social_facebook', $value[ 'facebook' ] );
			update_option( 'wcvendors_hide_signup_social_linkedin', $value[ 'linkedin' ] );
			update_option( 'wcvendors_hide_signup_social_youtube', $value[ 'youtube' ] );
			update_option( 'wcvendors_hide_signup_social_pinterest', $value[ 'pinterest' ] );
			update_option( 'wcvendors_hide_signup_social_google_plus', $value[ 'google_plus' ] );
			update_option( 'wcvendors_hide_signup_social_snapchat', $value[ 'snapchat' ] );

		} else {

				if ( $value == 1 ) $value = 'yes';

			update_option( $mappings[ $setting ], $value );
		}
	}


}

/**
* Finish Settings update
*
* @since 1.5.0
*/
function wcv_update_150_db_version(){
	WCVendors_Pro_Activator::update_db_version( '1.5.0' );
	$notice =  __( '<p>WC Vendors Pro has been updated.</p>', 'wcvendors-pro' );
	WCVendors_Admin_Notices::add_custom_notice( 'upgrade_pro', $notice );
}
