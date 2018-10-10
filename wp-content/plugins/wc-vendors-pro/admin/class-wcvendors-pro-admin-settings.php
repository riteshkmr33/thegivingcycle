<?php

/**
 * The WC Vendors Pro settings
 *
 * Defines the WC Vendors Pro settings that hook into WC Vendors
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/admin
 * @author     Jamie Madden <support@wcvendors.com>
 */

class WCVendors_Pro_Admin_Settings{

	public function __construct(){

		add_filter( 'wcvendors_get_settings_pages', array( $this, 'forms_page' ) );
		add_filter( 'wcvendors_settings_general', 			array( $this, 'general_settings' ) );

		// Hook into existing sections
		add_filter( 'wcvendors_get_settings_general', 		array( $this, 'general' ) );
		add_filter( 'wcvendors_get_settings_display', 		array( $this, 'display' ) );
		add_filter( 'wcvendors_get_settings_commission', 	array( $this, 'commission' ) );
		add_filter( 'wcvendors_get_settings_capabilities', 	array( $this, 'capabilities' ) );

		// Get Sections
		add_filter( 'wcvendors_get_sections_display', 		array( $this, 'get_display_sections' ) );
		add_filter( 'wcvendors_get_sections_capabilities',  array( $this, 'get_capabilities_sections' ) );

		// Section definitions
		add_filter( 'wcvendors_get_settings_display', 		array( $this, 'display_sections' ), 10, 2 );
		add_filter( 'wcvendors_get_settings_capabilities', 	array( $this, 'capabilities_sections' ), 10, 2 );


	}

	/**
	* Hook the forms page into the settings
	*
	* @since 2.0.0
	*/
	public function forms_page( $settings ){

		$settings[] = include( WCV_PRO_ABSPATH_ADMIN  . 'settings/class-wcvendors-pro-settings-forms.php' );
		$settings[] = include( WCV_PRO_ABSPATH_ADMIN  . 'settings/class-wcvendors-pro-settings-ratings.php' );

		return $settings;
	}


	/**
	*	General settings
	*
	*/
	public function general_settings( $settings ){

		$general_settings = apply_filters( 'wcvendors_pro_general_settings', array(

		) );

		// $settings = array_merge( $general_settings, $settings );

		return apply_filters( 'wcvendors_pro_get_settings_general', $settings );
	}


	/**
	*	Display sections settings
	*
	*/
	public function get_display_sections( $sections ){
		$sections[ 'pro_dashboard' ] = __( 'Pro Dashboard', 'wcvendors-pro' );
		$sections[ 'branding' ] = __( 'Branding', 'wcvendors-pro' );
		$sections[ 'notices' ] = __( 'Notices', 'wcvendors-pro' );
		return apply_filters( 'wcvendors_pro_get_sections_display', $sections );
	}

	/**
	*	Capabilities sections settings
	*
	*/
	public function get_capabilities_sections( $sections ){
		$sections[ 'trash' ] = __( 'Trash', 'wcvendors-pro' );
		return apply_filters( 'wcvendors_pro_get_sections_capabilities', $sections );
	}


	/**
	*	General settings
	*
	*/
	public function general( $settings ){

		$new_settings = array();

		foreach ( $settings as $setting ) {

				// general
			    if ( isset( $setting['id'] ) && 'general_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

			    	// Wordpress Dashboard access
					$new_settings[ ] = array(
						'title' => __( 'WordPress Dashboard', 'wcvendors-pro' ),
						'desc' => __( 'Only administrators can access the /wp-admin/ dashboard. ', 'wcvendors-pro' ),
						'tip'  => sprintf( __( 'Lock %s out of the /wp-admin/ area.', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
						'id'   => 'wcvendors_disable_wp_admin_vendors',
						'type' => 'checkbox',
						'default'  => false,
					);

					// Vendor Redirect
					$new_settings[] = array(
						'title' => __( 'Vendor Login Redirect', 'wcvendors-pro' ),
						'desc' => sprintf( __( 'Choose which page %s are redirected to after login. ', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
						'id'       => 'wcvendors_vendor_login_redirect',
						'type'     => 'select',
						'class'    	=> 'wc-enhanced-select-nostd',
						'css'      	=> 'min-width:300px;',
						'options' => apply_filters( 'wcvendors_vendor_login_redirect_args', array(
								'my-account' => __( 'My Account',  'wcvendors-pro' ),
								'dashboard'  => __( 'Dashboard', 'wcvendors-pro' ),
						) ),
						'default'	=> 'my-account'
					);
			    }

			    $new_settings[] = $setting;

		}

		return apply_filters( 'wcvendors_pro_get_settings_general', $new_settings );
	}

	/**
	* Add pro features to general capabilities tab
	*
	*
	* @since 2.0.0
	*/
	public function capabilities( $settings ){

		$new_settings = array();

		foreach ( $settings as $setting ) {

			// Pro Features
		    if ( isset( $setting['id'] ) && 'permissions_orders_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

		    	$new_settings[] = $setting;

		    	// Pro features
				$pro_features = apply_filters( 'wcvendors_pro_settings_capabilities_general_features', array(
						// Shop Display Options
						array(
							'title'    => __( 'Pro Features', 'wc-vendors' ),
							'type'     => 'title',
							'desc'     => sprintf( __( 'Enable and disable the pro features for the %s dashboard', 'wc-vendors' ), lcfirst( wcv_get_vendor_name() ) ),
							'id'       => 'pro_features_options',
						),

						array(
							'title' => __( 'Product Management', 'wcvendors-pro' ),
							'desc' => __( 'Disable product management in pro dashboard. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the product management from the pro dashboard.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_product_management_cap',
							'type' => 'checkbox',
							'default'  => false,
						),
						array(
							'title' => __( 'Order Management', 'wcvendors-pro' ),
							'desc' => __( 'Disable order management in pro dashboard. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the order management from the pro dashboard.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_order_management_cap',
							'type' => 'checkbox',
							'default'  => false,
						),
						array(
							'title' => __( 'Coupon Management', 'wcvendors-pro' ),
							'desc' => __( 'Disable coupon management in pro dashboard. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the coupon management from the pro dashboard.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_shop_coupon_management_cap',
							'type' => 'checkbox',
							'default'  => false,
						),
						array(
							'title' => __( 'Settings Management', 'wcvendors-pro' ),
							'desc' => __( 'Disable store settings management in pro dashboard. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the store settings management from the pro dashboard.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_settings_management_cap',
							'type' => 'checkbox',
							'default'  => false,
						),
						array(
							'title' => __( 'Ratings', 'wcvendors-pro' ),
							'desc' => __( 'Disable the ratings system completely. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the ratings system from the front end completely.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_ratings_management_cap',
							'type' => 'checkbox',
							'default'  => false,
						),
						array(
							'title' => sprintf( __( '%s Shipping', 'wcvendors-pro' ), wcv_get_vendor_name( false ) ),
							'desc' => __( 'Disable the vendor shipping system completely. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the vendor shipping system from the front end completely.', 'wcvendors-pro' ),
							'id'   => 'shipping_management_cap',
							'type' => 'checkbox',
							'default'  => false,
						),
						array(
							'title' => __( 'View Store', 'wcvendors-pro' ),
							'desc' => __( 'Disable the view store button on the pro dashboard. ', 'wcvendors-pro' ),
							'tip'  => __( 'Check to remove the view store button from the navigation.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_view_store_cap',
							'type' => 'checkbox',
							'default'  => false,
						),


						array( 'type' => 'sectionend', 'id' => 'pro_features_options' ),
					) );

				$new_settings = array_merge( $new_settings, $pro_features );
		    }


		    // Pro Features
		    if ( isset( $setting['id'] ) && 'order_view_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

		    	$new_settings[] = $setting;

		    	// Pro features
				$pro_features = apply_filters( 'wcvendors_pro_settings_capabilities_general_features', array(
						// Shop Display Options
						array(
							'title'    => __( 'Order Table', 'wc-vendors' ),
							'type'     => 'title',
							'desc'     => sprintf( __( 'Configure which actions to disable on the orders table for %s', 'wc-vendors' ), lcfirst( wcv_get_vendor_name( false ) ) ),
							'id'       => 'order_table_options',
						),

						array(
							'title' => __( 'Orders Table Actions', 'wcvendors-pro' ),
							'desc' => __( 'View order details', 'wcvendors-pro' ),
							'tip'  => __( 'Hide the view details action from the orders table.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_hide_order_view_details',
							'type' => 'checkbox',
							'default'  => false,
						),

						array(
							'desc' => __( 'Shipping label', 'wcvendors-pro' ),
							'tip'  => __( 'Hide the shipping label action from the orders table.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_hide_order_shipping_label',
							'type' => 'checkbox',
							'default'  => false,
						),

						array(
							'desc' => __( 'Order note', 'wcvendors-pro' ),
							'tip'  => __( 'Hide the order note action from the orders table.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_hide_order_order_note',
							'type' => 'checkbox',
							'default'  => false,
						),

						array(
							'desc' => __( 'Tracking number', 'wcvendors-pro' ),
							'tip'  => __( 'Hide the tracking number action from the orders table.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_hide_order_tracking_number',
							'type' => 'checkbox',
							'default'  => false,
						),

						array(
							'desc' => __( 'Mark shipped', 'wcvendors-pro' ),
							'tip'  => __( 'Hide the mark shipped action from the orders table.', 'wcvendors-pro' ),
							'id'   => 'wcvendors_hide_order_mark_shipped',
							'type' => 'checkbox',
							'default'  => false,
						),


						array( 'type' => 'sectionend', 'id' => 'order_table_options' ),
					) );

				$new_settings = array_merge( $new_settings, $pro_features );
		    }


		    // Edit approved products
		    if ( isset( $setting['id'] ) && 'permissions_products_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

		    	$new_settings[] = array(
					'title' => __( 'Edit Approved Products', 'wcvendors-pro' ),
					'desc' => __( 'Publish edits to approved products. ( New products will still have to be approved )', 'wcvendors-pro' ),
					'tip'  => sprintf( __( 'Allow %s to edit products that have already been approved.', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					'id'   => 'wcvendors_capability_products_approved',
					'type' => 'checkbox',
					'default'  => false,
				);

		    }

		    // Delete product
		     if ( isset( $setting['id'] ) && 'wcvendors_capability_product_duplicate' == $setting['id'] ) {

		    	$new_settings[] = array(
					'title' => __( 'Delete Product', 'wcvendors-pro' ),
					'desc' => __( 'Disable the delete option on the product form. ', 'wcvendors-pro' ),
					'tip'  => __( 'Check to remove the delete button from the product table.', 'wcvendors-pro' ),
					'id'   => 'wcvendors_capability_product_delete',
					'type' => 'checkbox',
					'default'  => false,
				);

		    }


			$new_settings[] = $setting;
		}
		return $new_settings;
	}

	/**
	*	Display settings
	*
	*/
	public function display( $settings ){

		$new_settings = array();

		foreach ( $settings as $setting ) {


				// Pages
			    if ( isset( $setting['id'] ) && 'page_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

			    	$new_settings[] =  array(
						'title'    	=> __( 'Pro Dashboard', 'wc-vendors' ),
						'id'       	=> 'wcvendors_dashboard_page_id',
						'type'     	=> 'single_select_page',
						'default'  	=> '',
						'class'    	=> 'wc-enhanced-select-nostd',
						'css'      	=> 'min-width:300px;',
						'desc' 	   	=> sprintf(  __( '<br />The page to display the WC Vendors Pro dashboard. This page requires the <code>[wcv_pro_dashboard]</code> shortcode. <strong>This page should be separate to your vendors dashboard page above. Do not delete your vendors dashboard page.</strong>', 'wc-vendors' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					);
					$new_settings[] = array(
						'title'    	=> __( 'Vendor Ratings', 'wc-vendors' ),
						'id'       	=> 'wcvendors_feedback_page_id',
						'type'     	=> 'single_select_page',
						'default'  	=> '',
						'class'    	=> 'wc-enhanced-select-nostd',
						'css'      	=> 'min-width:300px;',
						'desc' 	   	=> sprintf(  __( '<br />The page to display the feedback from this will have the <code>[wcv_feedback_form]</code> shortcode.', 'wc-vendors' ), lcfirst( wcv_get_vendor_name( false ) ) ),
					);

			    }


			    // Shop Settings
			    if ( isset( $setting['id'] ) && 'wcvendors_display_shop_description_html' == $setting['id'] ) {


					$new_settings[]	= array(
						'title' => __( 'Shop Single Product Header', 'wcvendors-pro' ),
						'desc' => __( 'Enable shop headers on single product pages.', 'wcvendors-pro' ),
						'tip'  => __( 'Check to enable the entire header on /shop/product-category/product-name/', 'wcvendors-pro' ),
						'id'   => 'wcvendors_store_single_headers',
						'type' => 'checkbox',
						'default'  => false,
					);

			    	$new_settings[] = array(
						'title'     => __( 'Shop Header', 'wcvendors-pro' ),
						'desc'     => __( 'Which Shop header to use. Shop headers need to be enabled for this option to work.', 'wcvendors-pro' ),
						'id'       => 'wcvendors_vendor_store_header_type',
						'type'     => 'select',
						'class'    	=> 'wc-enhanced-select-nostd',
						'css'      	=> 'min-width:300px;',
						'options' => array(
								'free'		=> __( 'Free',  'wcvendors-pro' ),
								'pro'		=> __( 'Pro', 'wcvendors-pro' ),
						),
						'default'	=> 'pro'
					);

			    }


			    // Labels
			     if ( isset( $setting['id'] ) && 'label_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

			    	$new_settings[] =  array(
						'title' => __( 'Verified Vendor Label', 'wcvendors-pro' ),
						'desc' => __( 'Text to output on the verified vendor badge.', 'wcvendors-pro' ),
						'id'   => 'wcvendors_verified_vendor_label',
						'type' => 'text',
						'default'  => __( 'Verified Vendor', 'wcvendors-pro' ),
					);

					$new_settings[] = array(
						'title' => __( 'Vendor Ratings Label', 'wcvendors-pro' ),
						'desc' => __( 'The vendor ratings tab title on the single product page.', 'wcvendors-pro' ),
						'id'   => 'wcvendors_vendor_ratings_label',
						'type' => 'text',
						'default'  => __( 'Product Ratings', 'wcvendors-pro' ),
					);

			    }

			     // advanced
			     if ( isset( $setting['id'] ) && 'advanced_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

			    	$new_settings[] =  array(
						'title' => __( 'Disable Select2', 'wcvendors-pro' ),
						'desc' => __( 'Disable select2 from loading with pro.', 'wcvendors-pro' ),
						'tip'  => __( 'This will disable the included select2 scripts from loading', 'wcvendors-pro' ),
						'id'   => 'wcvendors_disable_select2',
						'type' => 'checkbox',
						'default'  => false,
					);

					$new_settings[] = array(
						'title' => __( 'Single Product Tools', 'wcvendors-pro' ),
						'desc' => __( 'Display product actions on the single product page for vendor.', 'wcvendors-pro' ),
						'tip'  => __( 'Diplay the enabled actions for edit/duplicate/delete on the single product page to the vendor.', 'wcvendors-pro' ),
						'id'   => 'wcvendors_single_product_tools',
						'type' => 'checkbox',
						'default'  => false,
					);

			    }



			    $new_settings[] = $setting;

		}



		return apply_filters( 'wcvendors_pro_get_settings_display', $new_settings );
	}


	/**
	*	Display extra sections
	*
	*/
	public function display_sections( $settings, $current_section ){


		if ( 'pro_dashboard' === $current_section ){

			$settings = apply_filters( 'wcvendors_pro_settings_display_prodashboard', array(
				// Branding display options
				array(
					'title'    => __( '', 'wc-vendors' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Display options for the pro dashboard', 'wc-vendors' ), lcfirst( wcv_get_vendor_name() ) ),
					'id'       => 'pro_dashboard_options',
				),

				array(
					'title'     => __( 'Dashboard Date Range', 'wcvendors-pro' ),
					'id'       => 'wcvendors_dashboard_date_range',
					'tip'  => __( 'Define the dashboard default date range.', 'wcvendors-pro' ),
					'options'  => array(
						'annually' 		=> __( 'Annually', 'wcvendors-pro' ),
						'quarterly' 	=> __( 'Quarterly', 'wcvendors-pro' ),
						'monthly'		=> __( 'Monthly', 'wcvendors-pro' ),
						'weekly'		=> __( 'Weekly', 'wcvendors-pro' ),
						'daily'			=> __( 'Daily', 'wcvendors-pro' ),
					),
					'type'     		=> 'radio',
					'default'	   => 'monthly'
				),
				array(
					'title'     => __( 'Orders Page Ranges', 'wcvendors-pro' ),
					'id'       => 'wcvendors_orders_sales_range',
					'tip'  => __( 'Define the orders sales page date range.', 'wcvendors-pro' ),
					'options'  => array(
						'annually' 		=> __( 'Annually', 'wcvendors-pro' ),
						'quarterly' 	=> __( 'Quarterly', 'wcvendors-pro' ),
						'monthly'		=> __( 'Monthly', 'wcvendors-pro' ),
						'weekly'		=> __( 'Weekly', 'wcvendors-pro' ),
						'daily'			=> __( 'Daily', 'wcvendors-pro' ),
					),
					'type'     => 'radio',
					'default'  => 'monthly'
				),
				array(
					'title' => __( 'Products per page', 'wcvendors-pro' ),
					'desc' 	=> __( 'How many products to display per page', 'wcvendors-pro' ),
					'id'   	=> 'wcvendors_products_per_page',
					'type' 	=> 'number',
					'default'  => 20,
				),
				array(
					'title' => __( 'Coupons per page', 'wcvendors-pro' ),
					'desc' 	=> __( 'How many coupons to display per page', 'wcvendors-pro' ),
					'id'   	=> 'wcvendors_coupons_per_page',
					'type' 	=> 'number',
					'default'  => 20,
				),

				array( 'type' => 'sectionend', 'id' => 'pro_dashboard_options' ),
			) );

			return $settings;

		} elseif ( 'branding' === $current_section ){

			$settings = apply_filters( 'wcvendors_pro_settings_display_branding', array(
				// Branding display options
				array(
					'title'    => __( 'Default Branding', 'wc-vendors' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Default branding for the %s shop', 'wc-vendors' ), lcfirst( wcv_get_vendor_name() ) ),
					'id'       => 'branding_options',
				),
				array(
					'title' => __( 'Default Store Banner', 'wcvendors-pro' ),
					'desc' => __( 'Select an image for the default shop header banner', 'wcvendors-pro' ),
					'id'   => 'wcvendors_default_store_banner_src',
					'type' => 'image',
					'css' => 'wcv-img-id button',
					'default'  => plugin_dir_url( dirname( __FILE__ ) ) . 'includes/assets/images/wcvendors_default_banner.jpg',
				),
				array( 'type' => 'sectionend', 'id' => 'branding_options' ),
			) );

			return $settings;

		} elseif ( 'notices' === $current_section ){

			$settings = apply_filters( 'wcvendors_pro_settings_display_branding', array(
				// vendor notices
				array(
					'title'    => __( 'Notices', 'wc-vendors' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Display notices to the %s', 'wc-vendors' ), lcfirst( wcv_get_vendor_name() ) ),
					'id'       => 'notices_options',
				),
				array(
					'title' => sprintf( __( '%s Dashboard Notice', 'wcvendors-pro' ), wcv_get_vendor_name() ),
					'desc' => sprintf( __( 'Display a message to %s on all dashboard pages below the dashboard menu.', 'wcvendors-pro' ), lcfirst( wcv_get_vendor_name() ) ),
					'id'   => 'wcvendors_vendor_dashboard_notice',
					'css'		=> 'width: 700px;min-height:100px',
					'type' => 'textarea',
				),
				array( 'type' => 'sectionend', 'id' => 'notices_options' ),

				// Signup notices
				array(
					'title'    => __( 'Signup Notices', 'wc-vendors' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'These options allow you to provide messages to %s signing up to your market place.', 'wc-vendors' ), lcfirst( wcv_get_vendor_name() ) ),
					'id'       => 'signup_notices_options',
				),
				array(
					'title' => __( 'Vendor signup notice', 'wcvendors-pro' ),
					'desc' => __( 'Display a message to vendors on signup page, this could include store specific instructions.', 'wcvendors-pro' ),
					'id'   => 'wcvendors_vendor_signup_notice',
					'type' => 'wysiwyg',
				),
				array(
					'title' => __( 'Pending vendor message', 'wcvendors-pro' ),
					'desc' => __( 'Display a message to pending vendors after they have applied.', 'wcvendors-pro' ),
					'id'   => 'wcvendors_vendor_pending_notice',
					'css'		=> 'width: 700px;min-height:100px',
					'type' => 'textarea',
					'default' => __( 'Your application has been received. You will be notified by email the results of your application.', 'wcvendors-pro' ),
				),
				array(
					'title' => __( 'Approved vendor message', 'wcvendors-pro' ),
					'desc' => __( 'Display a message on the dashboard for approved vendors.' , 'wcvendors-pro' ),
					'id'   => 'wcvendors_vendor_approved_notice',
					'css'		=> 'width: 700px;min-height:100px',
					'type' => 'textarea',
					'default' => __( 'Congratulations! You are now a vendor. Be sure to configure your store settings before adding products.', 'wcvendors-pro' ),
				),

				array( 'type' => 'sectionend', 'id' => 'signup_notices_options' ),



			) );

			return $settings;

		} else {
			return $settings;
		}

	}

	/**
	*	Capabilities trash settings
	*
	*/
	public function capabilities_sections( $settings, $current_section ){


		if ( 'trash' === $current_section ){

			$settings = apply_filters( 'wcvendors_pro_settings_capabilities_trash', array(
				// Trash options
				array(
					'title'    => __( '', 'wc-vendors' ),
					'type'     => 'title',
					'desc'     => sprintf( __( 'Default behaviour when a %s deletes something', 'wc-vendors' ), lcfirst( wcv_get_vendor_name() ) ),
					'id'       => 'trash_options',
				),
				array(
					'title' => __( 'Product Delete', 'wcvendors-pro' ),
					'desc' => __( 'Delete vendor products permanently. ', 'wcvendors-pro' ),
					'tip'  => __( 'Bypass the trash when a vendor deletes a product and delete permanently.', 'wcvendors-pro' ),
					'id'   => 'wcvendors_vendor_product_trash',
					'type' => 'checkbox',
					'default'  => false,
				),

				array(
					'title' => __( 'Coupon Delete', 'wcvendors-pro' ),
					'desc' => __( 'Delete vendor coupons permanently. ', 'wcvendors-pro' ),
					'tip'  => __( 'Bypass the trash when a vendor deletes a coupon and delete permanently.', 'wcvendors-pro' ),
					'id'   => 'wcvendors_vendor_coupon_trash',
					'type' => 'checkbox',
					'default'  => false,
				),

				array( 'type' => 'sectionend', 'id' => 'trash_options' ),

			) );

			return $settings;

		} else {
			return $settings;
		}

	}

	/**
	*	Commission settings
	*
	*/
	public function commission( $settings ){

		$new_settings = array();

		foreach ( $settings as $setting ) {

		  	if ( isset( $setting['id'] ) && 'wcvendors_vendor_commission_rate' == $setting['id'] ) {

		  		$new_settings[ ] = array(
					'title'     => __( 'Global Commission Type', 'wcvendors-pro' ),
					'desc'     => __( 'This is the default commission type for all vendors.', 'wcvendors-pro' ),
					'id'       => 'wcvendors_commission_type',
					'type'     => 'select',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'options' => WCVendors_Pro_Commission_Controller::commission_types(),
					'default'	=> 'percent'
				);

		  	}

			// commission
		    if ( isset( $setting['id'] ) && 'commission_options' == $setting['id'] && isset( $setting['type'] ) && 'sectionend' == $setting['type'] ) {

				$new_settings[ ] = array(
					'title'     => __( 'Commission amount', 'wcvendors-pro' ),
					'desc'     => __( 'The fixed amount of commission you give the vendors.', 'wcvendors-pro' ),
					'id'       => 'wcvendors_commission_amount',
					'type'     => 'number',
				);

				$new_settings[ ] = array(
					'title'     => __( 'Commission fee', 'wcvendors-pro' ),
					'desc'     => __( 'This is the fee deducted from the commission amount.', 'wcvendors-pro' ),
					'id'       => 'wcvendors_commission_fee',
					'type'     => 'number',
				);

			    $new_settings[ ] = array(
					'title'     => __( 'Coupon Action', 'wcvendors-pro' ),
					'desc'     => __( 'Process the commission before or after the coupon has been applied to the price.', 'wcvendors-pro' ),
					'id'       => 'wcvendors_commission_coupon_action',
					'type'     => 'select',
					'class'    	=> 'wc-enhanced-select-nostd',
					'css'      	=> 'min-width:300px;',
					'options' => array(
							'yes'	=> __( 'After',  'wcvendors-pro' ),
							'no'	=> __( 'Before', 'wcvendors-pro' ),
					),
					'default'	=> 'yes'
				);

		    }

		    $new_settings[] = $setting;

		}

		return apply_filters( 'wcvendors_pro_get_settings_commission', $new_settings );
	}


}
return new WCVendors_Pro_Admin_Settings();
