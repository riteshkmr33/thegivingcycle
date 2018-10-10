<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The forms settings class
 *
 * @author      Jamie Madden, WC Vendors
 * @category    Settings
 * @package     WCVendors/Admin/Settings
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCVendors_Pro_Settings_Forms', false ) ) :

/**
 * WC_Admin_Settings_General.
 */
class WCVendors_Pro_Settings_Forms extends WCVendors_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'forms';
		$this->label = __( 'Forms', 'wcvendors-pro' );

		add_action( 'wcvendors_admin_field_form_fields_required', array( $this, 'generate_form_fields_required_html' ) );

		parent::__construct();
	}



	/**
	 * Get sections.
	 *
	 * @return array
	 */
	public function get_sections() {
		$sections = array(
			''          => __( 'General', 'wcvendors-pro' ),
			'product'	=> __( 'Product', 'wcvendors-pro' ),
			'settings'	=> __( 'Settings', 'wcvendors-pro' ),
			'signup'	=> __( 'Signup', 'wcvendors-pro' ),
		);

		return apply_filters( 'wcvendors_get_sections_' . $this->id, $sections );
	}

	/**
	* Save the fields including the required fields tables
	*
	*
	*/
	public function save() {

		global $current_section;

		$options = array();
		$settings = $this->get_settings( $current_section );

		foreach ( $settings as $setting ) {

			if ( $setting[ 'type'] === 'form_fields_required' ) {

				if ( isset( $setting['fields'] ) && !empty( $setting[ 'fields'] )  ){
					foreach ( $setting[ 'fields' ] as $field ) {
						$options[] = $field;
						// create the second field for saving
						if ( array_key_exists('required_id', $field ) ){
							$required_field = $field;
							$required_field[ 'id' ] = $field[ 'required_id' ];
							$options[] = $required_field;
						}
					}
				}
			}
		}

		WCVendors_Admin_Settings::save_fields( $options );

		parent::save();

	} // save()

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {


		if ( 'signup' === $current_section ){

			$settings = apply_filters( 'wcvendors_pro_settings_forms_signup', array(
				// Shop Display Options
					array(
					'title'    => __( 'Signup Form', 'wcvendors-pro' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Configure which fields the vendor signup form should show or be required', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'       => 'settings_options',
				),

				array(
					'title'     => __( 'Tabs', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Payment', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_tab_payment',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Branding', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_tab_branding',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Shipping', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_tab_shipping',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Social', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_tab_social',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'SEO', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_tab_seo',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Store', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Store description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_store_description',
							'required_id'	=> 'wcvendors_required_signup_store_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Seller info', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_store_seller_info',
							'required_id'	=> 'wcvendors_required_signup_store_seller_info',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Company / blog URL', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_store_company_url',
							'required_id'	=> 'wcvendors_required_signup_store_company_url',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Store phone', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_store_phone',
							'required_id'	=> 'wcvendors_required_signup_store_phone',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Store address ( if you use vendor shipping this option will not work. )', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_store_address',
							'required_id'	=> 'wcvendors_required_signup_store_address',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Vacation Mode ( Allow vendors to create a message to show on their stores. )', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_store_vacation_mode',
							'required_id'	=> 'wcvendors_required_signup_store_vacation_mode',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),

					),
				),

				array(
					'title'     => __( 'Payment', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Paypal email', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_paypal',
							// 'required_id'	=> 'wcvendors_required_signup_payment_paypal',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Bank Account Name', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_bank_account_name',
							// 'required_id'	=> 'wcvendors_required_signup_payment_bank_account_name',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Bank Account Number', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_bank_account_number',
							// 'required_id'	=> 'wcvendors_required_signup_payment_bank_account_number',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Bank Name', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_bank_name',
							// 'required_id'	=> 'wcvendors_required_signup_payment_bank_name',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Routing number', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_routing_number',
							// 'required_id'	=> 'wcvendors_required_signup_payment_routing_number',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'IBAN', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_iban',
							// 'required_id'	=> 'wcvendors_required_signup_payment_iban',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'BIC/SWIF', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_payment_bic_swift',
							// 'required_id'	=> 'wcvendors_required_signup_payment_bic_swift',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Branding', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Store banner', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_branding_store_banner',
							// 'required_id'	=> 'wcvendors_required_settings_branding_store_banner',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Store icon', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_branding_store_icon',
							// 'required_id'	=> 'wcvendors_required_settings_branding_store_icon',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Shipping', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Product handling fee', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_handling_fee',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_handling_fee',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Minimum order charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_min_charge',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_min_charge',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Maximum order charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_max_charge',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_max_charge',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Maximum product charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_max_charge_product',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_max_charge_product',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Free Shipping Order', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_free_shipping_order',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_free_shipping_order',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Free Shipping Product', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_free_shipping_product',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_free_shipping_product',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Shipping policy', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_shipping_policy',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_shipping_policy',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Return policy', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_shipping_return_policy',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_return_policy',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Social', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Twitter', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_twitter',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_twitter',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Instagram', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_instagram',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_instagram',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_facebook',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_facebook',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Linkedin', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_linkedin',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_linkedin',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Youtube', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_youtube',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_youtube',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Pinterest', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_pinterest',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_pinterest',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Google+', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_google_plus',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_google_plus',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Snapchat', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_social_snapchat',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_snapchat',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'SEO', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'SEO Title', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_title',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Meta Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_meta_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Meta Keywords', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_meta_keywords',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook Title', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_fb_title',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_fb_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook Image', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_fb_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Twitter Title', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_twitter_title',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Twitter Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_twitter_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Twitter Image', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_signup_seo_twitter_image',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array( 'type' => 'sectionend', 'id' => 'settings_options' ),

			) );

		} elseif ( 'settings' === $current_section ){

			$settings = apply_filters( 'wcvendors_pro_settings_forms_settings', array(

				// Vendor store settings
				array(
					'title'    => __( 'Settings Form', 'wcvendors-pro' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Configure which fields for the store settings form should show', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'       => 'settings_options',
				),

				array(
					'title'     => __( 'Tabs', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Payment', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_tab_payment',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Branding', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_tab_branding',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Shipping', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_tab_shipping',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Social', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_tab_social',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'SEO', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_tab_seo',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Store', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Store description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_store_description',
							'required_id'	=> 'wcvendors_required_settings_store_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Seller info', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_store_seller_info',
							'required_id'	=> 'wcvendors_required_settings_seller_info',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Company / blog URL', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_store_company_url',
							'required_id'	=> 'wcvendors_required_settings_store_company_url',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Store phone', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_store_phone',
							'required_id'	=> 'wcvendors_required_settings_store_phone',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Store address ( if you use vendor shipping this option will not work. )', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_store_address',
							'required_id'	=> 'wcvendors_required_settings_store_address',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Vacation Mode ( Allow vendors to create a message to show on their stores. )', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_store_vacation_mode',
							'required_id'	=> 'wcvendors_required_settings_store_vacation_mode',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),

					),
				),

				array(
					'title'     => __( 'Payment', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Paypal email', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_paypal',
							// 'required_id'	=> 'wcvendors_required_settings_payment_paypal',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Bank Account Name', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_bank_account_name',
							// 'required_id'	=> 'wcvendors_required_settings_store_payment_bank_account_name',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Bank Account Number', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_bank_account_number',
							// 'required_id'	=> 'wcvendors_required_settings_store_payment_bank_account',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Bank Name', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_bank_name',
							// 'required_id'	=> 'wcvendors_required_settings_payment_bank_name',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Routing number', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_routing_number',
							// 'required_id'	=> 'wcvendors_required_settings_payment_routing_number',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'IBAN', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_iban',
							// 'required_id'	=> 'wcvendors_required_settings_payment_iban',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'BIC/SWIF', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_payment_bic_swift',
							// 'required_id'	=> 'wcvendors_required_settings_payment_bic_swift',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Branding', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Store banner', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_branding_store_banner',
							// 'required_id'	=> 'wcvendors_required_settings_branding_store_banner',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Store icon', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_branding_store_icon',
							// 'required_id'	=> 'wcvendors_required_settings_branding_store_icon',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Shipping', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Product handling fee', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_handling_fee',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_handling_fee',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Minimum order charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_min_charge',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_min_charge',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Maximum order charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_max_charge',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_max_charge',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Maximum product charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_max_charge_product',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_max_charge_product',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Free Shipping Order', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_free_shipping_order',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_free_shipping_order',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Free Shipping Product', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_free_shipping_product',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_free_shipping_product',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Shipping policy', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_shipping_policy',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_shipping_policy',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Return policy', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_shipping_return_policy',
							// 'required_id'	=> 'wcvendors_required_settings_shipping_return_policy',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Social', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Twitter', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_twitter',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_twitter',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Instagram', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_instagram',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_instagram',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_facebook',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_facebook',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Linkedin', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_linkedin',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_linkedin',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Youtube', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_youtube',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_youtube',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Pinterest', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_pinterest',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_pinterest',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Google+', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_google_plus',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_google_plus',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Snapchat', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_social_snapchat',
							// 'required_id'	=> 'wcvendors_required_settings_ssocial_snapchat',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'SEO', 'wcvendors-pro' ),
					'desc'     	=> '',
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'SEO Title', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_title',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Meta Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_meta_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Meta Keywords', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_meta_keywords',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook Title', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_fb_title',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_fb_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Facebook Image', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_fb_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Twitter Title', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_twitter_title',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Twitter Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_twitter_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Twitter Image', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_settings_seo_twitter_image',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),


				array( 'type' => 'sectionend', 'id' => 'settings_options' ),

			) );

		} elseif ( 'product' === $current_section ){


			$settings = apply_filters( 'wcvendors_pro_settings_forms_product', array(

				// Product Form fields
				array(
					'title'    => __( 'Form Fields', 'wcvendors-pro' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Configure which fields for the product edit form should show and which are required', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'       => 'product_form_options',
				),

				array(
					'title'     => __( 'Basic', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=>  array(
						array(
							'title' 		=> __( 'Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_basic_description',
							'required_id'	=> 'wcvendors_required_product_basic_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Short Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_basic_short_description',
							'required_id'	=> 'wcvendors_required_product_basic_short_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Categories', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_basic_categories',
							'required_id'	=> 'wcvendors_required_product_basic_categories',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Tags', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_basic_tags',
							'required_id'	=> 'wcvendors_required_product_basic_tags',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Attributes', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_basic_attributes',
							'required_id'	=> 'wcvendors_required_product_basic_attributes',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Media', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=>  array(
							array(
								'title' 		=> __( 'Featured Image (also disables the gallery)', 'wcvendors-pro' ),
								'desc' 			=> '',
								'id'   			=> 'wcvendors_hide_product_media_featured',
								'required_id'	=> 'wcvendors_required_product_media_featured',
								'type' 		=> 'checkbox',
								'default'  	=> false,
							),
							array(
								'title' 		=> __( 'Gallery', 'wcvendors-pro' ),
								'desc' 			=> '',
								'id'   			=> 'wcvendors_hide_product_media_gallery',
								'required_id'	=> 'wcvendors_required_product_media_gallery',
								'type' 		=> 'checkbox',
								'default'  	=> false,
							),
						),
				),

				array(
					'title'     => __( 'General', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'SKU', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_sku',
							'required_id'	=> 'wcvendors_required_product_general_sku',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Private listing', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_private_listing',
							'required_id'	=> 'wcvendors_required_product_general_private_listing',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'External URL', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_sku',
							'required_id'	=> 'wcvendors_required_product_general_sku',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Button text for external url', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_button_text',
							'required_id'	=> 'wcvendors_required_product_general_button_text',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Price (disables sale price)', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_price',
							'required_id'	=> 'wcvendors_required_product_general_price',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Sale price', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_sale_price',
							'required_id'	=> 'wcvendors_required_product_general_sale_price',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Tax', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_tax',
							'required_id'	=> 'wcvendors_required_product_general_tax',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Download files (also disables all download fields)', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_download_files',
							'required_id'	=> 'wcvendors_required_product_general_download_files',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Disable vendors ability to change file URL to prevent remote file URLs', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_download_file_url',
							'required_id'	=> 'wcvendors_required_product_general_download_file_url',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Download limit', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_download_limit',
							'required_id'	=> 'wcvendors_required_product_general_download_limit',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),

						array(
							'title' 		=> __( 'Download expiry', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_download_expiry',
							'required_id'	=> 'wcvendors_required_product_general_download_expiry',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Download type', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_general_download_type',
							'required_id'	=> 'wcvendors_required_product_general_download_type',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),

					),
				),

				array(
					'title'     => __( 'Inventory', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Manage Inventory (also disables all inventory fields)', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_inventory_manage_inventory',
							'required_id'	=> 'wcvendors_required_product_inventory_manage_inventory',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Stock qty', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_inventory_stock_qty',
							'required_id'	=> 'wcvendors_required_product_inventory_stock_qty',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Backorders', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_inventory_backorders',
							'required_id'	=> 'wcvendors_required_product_inventory_backorders',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Stock status', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_inventory_stock_status',
							'required_id'	=> 'wcvendors_required_product_inventory_stock_status',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Sold individually', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_inventory_sold_individually',
							'required_id'	=> 'wcvendors_required_product_inventory_sold_individually',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),

					),
				),

				array(
					'title'     => __( 'Shipping', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Weight', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_weight',
							'required_id'	=> 'wcvendors_required_product_shipping_weight',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Product handling fee', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_handling_fee',
							'required_id'	=> 'wcvendors_required_product_shipping_handling_fee',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Maximum shipping charge', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_max_charge',
							'required_id'	=> 'wcvendors_required_product_shipping_max_charge',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Free Shipping Order', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_free_shipping_order',
							'required_id'	=> 'wcvendors_required_product_shipping_free_shipping_order',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Free Shipping Product', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_free_shipping_product',
							'required_id'	=> 'wcvendors_required_product_shipping_free_shipping_product',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Dimensions', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_dimensions',
							'required_id'	=> 'wcvendors_required_product_shipping_dimensions',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Shipping class', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_shipping_shipping_class',
							'required_id'	=> 'wcvendors_required_product_shipping_shipping_class',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),

				array(
					'title'     => __( 'Upsells / Cross sells', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> true,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Up sells', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_upsells_up_sells',
							'required_id'	=> 'wcvendors_required_product_upsells_up_sells',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Cross sells', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_upsells_crosssells',
							'required_id'	=> 'wcvendors_required_product_upsells_crosssells',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Grouped Products', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_upsells_grouped_products',
							'required_id'	=> 'wcvendors_required_product_upsells_grouped_products',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),

					),
				),

				array(
					'title'     => __( 'Variations', 'wcvendors-pro' ),
					'desc'     	=> '',
					'require'	=> false,
					'type'     	=> 'form_fields_required',
					'fields'	=> array(
						array(
							'title' 		=> __( 'Featured Image', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_featured',
							// 'required_id'	=> 'wcvendors_required_product_variations_featured',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'SKU', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_sku',
							// 'required_id'	=> 'wcvendors_required_product_variations_sku',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Enabled', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_enabled',
							// 'required_id'	=> 'wcvendors_required_product_variations_enabled',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Downloadable', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_downloadable',
							// 'required_id'	=> 'wcvendors_required_product_variations_downloadable',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Virtual', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_virtual',
							// 'required_id'	=> 'wcvendors_required_product_variations_virtual',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Manage Stock', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_manage_stock',
							// 'required_id'	=> 'wcvendors_required_product_variations_manage_stock',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Price', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_price',
							// 'required_id'	=> 'wcvendors_required_product_variations_price',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Sale Price', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_sale_price',
							// 'required_id'	=> 'wcvendors_required_product_variations_sale_price',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Stock QTY', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_stock_qty',
							// 'required_id'	=> 'wcvendors_required_product_variations_stock_qty',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Allow backorders', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_allow_backorders',
							// 'required_id'	=> 'wcvendors_required_product_variations_allow_backorders',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Stock Status', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_stock_status',
							// 'required_id'	=> 'wcvendors_required_product_variations_stock_status',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Weight', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_weight',
							// 'required_id'	=> 'wcvendors_required_product_variations_weight',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Dimensions', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_dimensions',
							// 'required_id'	=> 'wcvendors_required_product_variations_dimensions',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Shipping Class', 'wcvendors-pro' ),
							'desc' 			=> 'shipping_class',
							'id'   			=> 'wcvendors_hide_product_variations_shipping_class',
							// 'required_id'	=> 'wcvendors_required_product_variations_shipping_class',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Tax Class', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_tax_class',
							// 'required_id'	=> 'wcvendors_required_product_variations_tax_class',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Description', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_description',
							// 'required_id'	=> 'wcvendors_required_product_variations_description',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Download files ( disables all download fields on variations )', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_download_files',
							// 'required_id'	=> 'wcvendors_required_product_variations_download_files',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Download limit', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_download_limit',
							// 'required_id'	=> 'wcvendors_required_product_variations_download_limit',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
						array(
							'title' 		=> __( 'Download expiry', 'wcvendors-pro' ),
							'desc' 			=> '',
							'id'   			=> 'wcvendors_hide_product_variations_download_expiry',
							// 'required_id'	=> 'wcvendors_required_product_variations_download_expiry',
							'type' 		=> 'checkbox',
							'default'  	=> false,
						),
					),
				),
				// array( 'type' => 'sectionend', 'id' => 'variations_form_options' ),

				// 	),
				// ),

				array( 'type' => 'sectionend', 'id' => 'product_form_options' ),


				// Product Form Options
				array(
					'title'    => __( 'Product Form', 'wcvendors-pro' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Configure the product edit form options for %s', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'       => 'product_options',
				),

				array(
					'title'    	=> __( 'Default Product Form', 'wcvendors-pro' ),
					'desc'     	=> __( 'Which product form to use.', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_product_form_template',
					'type'     	=> 'select',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'options' 	=> WCVendors_Pro_Product_Controller::product_templates(),
					'default'	=> 'select'
				),

				array(
					'title'     => __( 'Save Product Redirect', 'wcvendors-pro' ),
					'desc'     	=> __( 'After vendor saves the product redirect to.', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_save_product_redirect',
					'type'     	=> 'select',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'class'    	=> 'wc-enhanced-select-nostd',
					'options' 	=> array(
							'edit'	=> __( 'Edit product form',  'wcvendors-pro' ),
							'list'	=> __( 'Product list', 'wcvendors-pro' ),
							'view'	=> __( 'Published/Preview Product', 'wcvendors-pro' ),
							'empty'	=> __( 'Add new product', 'wcvendors-pro' ),
					),
					'default'	=> 'empty'
				),

				array(
					'title'     => __( 'Category Display', 'wcvendors-pro' ),
					'desc'     	=> __( 'What kind of category selection.', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_category_display',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'type'     	=> 'select',
					'options' 	=> array(
							'select'	=> __( 'Multi select',  'wcvendors-pro' ),
							'checklist'	=> __( 'Check list', 'wcvendors-pro' ),
					),
					'default'	=> 'select'
				),

				array(
					'title'     => __( 'Hide Categories', 'wcvendors-pro' ),
					'desc'     	=> __( 'A comma separated list of categories to hide from the vendor product form. ', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_hide_categories_list',
					'type'     	=> 'text',
				),

				array(
					'title'     => __( 'Categories limit', 'wcvendors-pro' ),
					'desc'     	=> __( 'Limit the number of categories a vendor can select. ', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_category_limit',
					'type'     	=> 'text',
					'default' 	=> ''
				),

				array(
					'title'     => __( 'Tag Display', 'wcvendors-pro' ),
					'desc'     	=> __( 'What kind of tag selection.', 'wcvendors-pro' ),
					'id'      	=> 'wcvendors_tag_display',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'type'     	=> 'select',
					'options' 	=> array(
							'select'			=> __( 'Multi select',  'wcvendors-pro' ),
							'select_limited'	=> __( 'Multi select limited', 'wcvendors-pro' ),
					),
					'default'	=> 'select'
				),

				array(
					'title'     => __( 'Tag Separator', 'wcvendors-pro' ),
					'desc'     	=> __( 'What kind of tag separator.', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_tag_separator',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'type'     	=> 'select',
					'options' 	=> array(
							'both'			=> __( 'Comma (,) and space ( )',  'wcvendors-pro' ),
							'space'			=> __( 'Space only ( )', 'wcvendors-pro' ),
							'comma'			=> __( 'Comma only (,)', 'wcvendors-pro' ),
					),
					'default'	=> 'select'
				),

				array(
					'title'     => __( 'File Display', 'wcvendors-pro' ),
					'desc'     	=> __( 'The format to display on the file uploader.', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_file_display',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'type'     	=> 'select',
					'options' 	=> array(
							'file_url'		=> __( 'File URL',  'wcvendors-pro' ),
							'file_name'		=> __( 'File name', 'wcvendors-pro' ),
					),
					'default'	=> 'file_url'
				),

				array(
					'title'     => __( 'Hide Attributes', 'wcvendors-pro' ),
					'desc'     	=> __( 'A comma separated list of attributes to hide from the vendor product form. ', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_hide_attributes_list',
					'type'     	=> 'text',
				),

				array(
					'title'     => __( 'Vendor filename prefix', 'wcvendors-pro' ),
					'desc'     	=> __( 'Prefix all vendor file name uploads', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_vendor_image_prefix',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'type'     	=> 'select',
					'options' 	=> array(
							'none'				=> __( 'No file prefix', 'wcvendors-pro' ),
							'vendor_id'			=> __( 'Vendor ID',  'wcvendors-pro' ),
							'vendor_username'	=> __( 'Vendor Username', 'wcvendors-pro' ),
					),
					'default'	=> 'none'
				),

				array(
					'title'     => __( 'Max Gallery Images', 'wcvendors-pro' ),
					'desc'     	=> __( 'The maximum number of images that can be uploaded to the gallery. ', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_product_max_gallery_count',
					'type'     	=> 'number',
					'default'	   => 4,
				),

				array(
					'title'     => __( 'Max image width', 'wcvendors-pro' ),
					'desc'     	=> __( 'The maximum allowed width (px) for an uploaded image', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_product_max_image_width',
					'type'     	=> 'number',
				),

				array(
					'title'     => __( 'Max image height', 'wcvendors-pro' ),
					'desc'     	=> __( 'The maximum allowed height (px) for an uploaded image', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_product_max_image_height',
					'type'     	=> 'number',
				),

				array(
					'title'     => __( 'Min image width', 'wcvendors-pro' ),
					'desc'     	=> __( 'The minimum allowed width (px) for an uploaded image', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_product_min_image_width',
					'type'     	=> 'number',
				),

				array(
					'title'     => __( 'Min image height', 'wcvendors-pro' ),
					'desc'     	=> __( 'The minimum allowed height (px) for an uploaded image', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_product_min_image_height',
					'type'     	=> 'number',
				),

				array( 'type' => 'sectionend', 'id' => 'product_options' ),

			) );


		}  else {

			$settings = apply_filters( 'wcvendors_pro_settings_forms_general', array(

				//  General Options
				array(
					'title'    	=> __( 'General', 'wcvendors-pro' ),
					'type'     	=> 'title',
					'desc'		=> sprintf( __( 'General options applicable to all forms.', 'wcvendors-pro'), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'       	=> 'general_options',
				),
				array(
					'title' => __( 'Allow HTML in Inputs', 'wcvendors-pro' ),
					'desc' => sprintf( __( 'Allow %s to add html source to the inputs and text areas on forms.', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'tip'  => sprintf( __( 'This will allow vendors the ability to add html source code to their inputs and text areas.', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'   => 'wcvendors_allow_form_markup',
					'type' => 'checkbox',
					'default'  => false,
				),
				array(
					'title'		=> __( 'Vendor filename prefix', 'wcvendors-pro' ),
					'desc'     	=> __( 'Prefix all vendor file name uploads', 'wcvendors-pro' ),
					'id'       	=> 'wcvendors_vendor_image_prefix',
					'type'     	=> 'select',
					'options' 	=> array(
							'none'				=> __( 'No file prefix', 'wcvendors-pro' ),
							'vendor_id'			=> __( 'Vendor ID',  'wcvendors-pro' ),
							'vendor_username'	=> __( 'Vendor Username', 'wcvendors-pro' ),
					),
					'default'	=> 'none'
				),

				array( 'type' => 'sectionend', 'id' => 'general_options' ),

			) );

		}

		return apply_filters( 'wcvendors_get_settings_' . $this->id, $settings, $current_section );

	}

	/**
	* Output the form fields table
	*
	*/
	public function generate_form_fields_required_html( $value ){

		$require 			= isset( $value[ 'require' ] ) ? $value[ 'require' ] : false;
		$field_description 	= WCVendors_Admin_Settings::get_field_description( $value );
		extract( $field_description );

		?>
		<tr valign="top" class="wcv_form_fields_table">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value[ 'id' ] ); ?>"><?php echo wp_kses_post( $value['title'] ); ?></label>

			</th>
			<td class="forminp">
				<?php echo ( $description ) ? $description : ''; ?>
				<div class="wcv-form_fields_required">
					<?php include( apply_filters( 'wcv_partial_path_pro_form_fields_required' , 'partials/html-form-fields-table.php' ) ); ?>
				</div>

			</td>
		</tr>
		<?php

	}

}

endif;

return new WCVendors_Pro_Settings_Forms();
