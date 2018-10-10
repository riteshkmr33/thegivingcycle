<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/admin
 * @author     Jamie Madden <support@wcvendors.com>
 */

class WCVendors_Pro_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wcvendors_pro    The ID of this plugin.
	 */
	private $wcvendors_pro;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Script suffix for debugging
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $suffix    script suffix for including minified file versions
	 */
	private $suffix;

	/**
	 * Is the plugin in debug mode
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $debug    plugin is in debug mode
	 */
	private $debug;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $wcvendors_pro       The name of this plugin.
	 * @param    string    $version    		The version of this plugin.
	 */
	public function __construct( $wcvendors_pro, $version, $debug ) {

		$this->wcvendors_pro 	= $wcvendors_pro;
		$this->version 			= $version;
		$this->debug 			= $debug;
		$this->base_dir			= plugin_dir_url( __FILE__ );
		$this->plugin_base_dir	= plugin_dir_path( dirname(__FILE__) );
		$this->suffix		 	= $this->debug ? '' : '.min';

	}

	/**
	*
	*/
	public function process_submit( ){

		if ( isset( $_GET[ 'wcv_export_commissions' ] ) ) {
			$this->export_csv();
		}
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$screen 	= get_current_screen();
		$vendor_id 	= get_current_user_id();
		$screen_id  = $screen->id;
		$product 	= 0;

		if ( $screen->id == 'user-edit' || $screen->id == 'woocommerce_page_wc-settings' ) {
			global $user_id;
			$vendor_id = $user_id;
			//font awesome for social icons
			wp_enqueue_style( 'font-awesome', 	$this->base_dir . '../includes/assets/lib/font-awesome-4.6.3/css/font-awesome.min.css', array(), '4.6.3', 'all' );
		} elseif ( $screen->id == 'product' ){
			global $post;
			$product = $post;
		}

		wp_enqueue_script( 'postbox' );
		wp_enqueue_media();

		$shipping_settings 		= get_option( 'woocommerce_wcv_pro_vendor_shipping_settings' );
		$store_shipping_type	= get_user_meta( $vendor_id, '_wcv_shipping_type', true );
		$shipping_type 			= ( $store_shipping_type != '' ) ? $store_shipping_type : $shipping_settings[ 'shipping_system' ];

		// Variables to pass to javascript in admin
		$admin_args = array(
			'screen_id'				=> $screen_id,
			'product'				=> $product,
			'vendor_shipping_type' 	=> $store_shipping_type,
			'global_shipping_type' 	=> $shipping_settings[ 'shipping_system' ],
			'current_shipping_type'	=> $shipping_type,
		);

		wp_register_script( 'wcv-admin-js', $this->base_dir . 'assets/js/wcvendors-pro-admin' . $this->suffix	 . '.js', array('jquery' ), WCV_PRO_VERSION, true );
		wp_localize_script( 'wcv-admin-js', 'wcv_admin', $admin_args );
		wp_enqueue_script( 'wcv-admin-js' );

		// Admin style
		wp_enqueue_style( 'wcv-admin-css', 	$this->base_dir . 'assets/css/wcvendors-pro-admin' . $this->suffix . '.css', array(), WCV_PRO_VERSION, 'all' );

		if ( $screen->id == 'user-edit' || $screen->id == 'product' || $screen->id == 'woocommerce_page_wc-settings' ){
			// Country select
			$country_select_args = array(
				'countries'                 => json_encode( array_merge( WC()->countries->get_allowed_country_states(), WC()->countries->get_shipping_country_states() ) ),
				'i18n_select_state_text'    => esc_attr__( 'Select an option&hellip;', 'wcvendors-pro' ),
				'i18n_matches_1'            => _x( 'One result is available, press enter to select it.', 'enhanced select', 'wcvendors-pro' ),
				'i18n_matches_n'            => _x( '%qty% results are available, use up and down arrow keys to navigate.', 'enhanced select', 'wcvendors-pro' ),
				'i18n_no_matches'           => _x( 'No matches found', 'enhanced select', 'wcvendors-pro' ),
				'i18n_ajax_error'           => _x( 'Loading failed', 'enhanced select', 'wcvendors-pro' ),
				'i18n_input_too_short_1'    => _x( 'Please enter 1 or more characters', 'enhanced select', 'wcvendors-pro' ),
				'i18n_input_too_short_n'    => _x( 'Please enter %qty% or more characters', 'enhanced select', 'wcvendors-pro' ),
				'i18n_input_too_long_1'     => _x( 'Please delete 1 character', 'enhanced select', 'wcvendors-pro' ),
				'i18n_input_too_long_n'     => _x( 'Please delete %qty% characters', 'enhanced select', 'wcvendors-pro' ),
				'i18n_selection_too_long_1' => _x( 'You can only select 1 item', 'enhanced select', 'wcvendors-pro' ),
				'i18n_selection_too_long_n' => _x( 'You can only select %qty% items', 'enhanced select', 'wcvendors-pro' ),
				'i18n_load_more'            => _x( 'Loading more results&hellip;', 'enhanced select', 'wcvendors-pro' ),
				'i18n_searching'            => _x( 'Searching&hellip;', 'enhanced select', 'wcvendors-pro' ),
			);

			wp_register_script( 'wcv-country-select', $this->base_dir . '../includes/assets/js/country-select' . $this->suffix	 . '.js', array( 'jquery' ), WCV_PRO_VERSION, true );
			wp_localize_script( 'wcv-country-select', 'wcv_country_select_params',  $country_select_args );
			wp_enqueue_script( 'wcv-country-select' );

		}
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 * @return   array 			Action links
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=wcv-settings' ) . '">' . __( 'Settings', 'wcvendors-pro' ) . '</a>'
				),
			$links
			);

	} // add_action_links()

	/**
	 * Lock a vendor out of the wp-admin
	 *
	 * @since    1.0.0
	 * @version  1.4.0
	*/
	public function admin_lockout( ) {

		if ( 'yes' == get_option( 'wcvendors_disable_wp_admin_vendors' ) ) {

			// Need to make this filterable somehow.
			$capabilities = array( 'manage_woocommerce' );

			foreach ( $capabilities as $capability ) {

				if ( ! current_user_can( $capability ) && ! defined( 'DOING_AJAX' ) ) {
					add_action( 'admin_init',     array( $this, 'admin_redirect' ) );
				} else {
					return;
				}
			}

		}

	} // admin_lockout()

	/**
	 * Redirect to pro dashboard if attempting to access wordpress dashboard
	 *
	 * @since    1.0.0
	*/
	public function admin_redirect( ) {

		$redirect_page = apply_filters( 'wcv_admin_lockout_redirect_url', get_permalink( get_option( 'wcvendors_dashboard_page_id' ) ) );
		wp_redirect( $redirect_page );

	} //admin_redirect()


	/**
	 * Output system status information for pro
	 *
	 * @since    1.0.3
	*/
	public function wcvendors_pro_system_status( ) {

		$free_dashboard_page 	= get_option( 'wcvendors_vendor_dashboard_page_id' );
		$pro_dashboard_page 	= get_option( 'wcvendors_dashboard_page_id' );
		$feedback_form_page 	= get_option( 'wcvendors_feedback_page_id' );
		$vendor_shop_permalink  = get_option( 'wcvendors_vendor_shop_permalink' );

		$woocommerce_override   = locate_template( 'woocommerce.php' );

		include_once( apply_filters( 'wcv_wcvendors_pro_system_status_path', 'partials/wcvendors-pro-system-status.php') );

	} // wcvendors_pro_system_status()

	/**
	 * Template for system status information for pro
	 *
	 * @since    1.0.3
	*/
	public function wcvendors_pro_template_status() {

		include_once( apply_filters( 'wcvendors_pro_template_status', 'partials/wcvendors-pro-template-status.php' ) );

	} // wcvendors_pro_template_status()

	/**
	 * Load the new wc vendors shipping module
	 *
	 * @since    1.1.0
	*/
	public function wcvendors_pro_shipping_init( ){

		if ( ! class_exists( 'WCVendors_Pro_Shipping_Method' ) ){
			include( 'class-wcvendors-pro-shipping.php' );
		}

	} // wcvendors_pro_shipping_init()

	/**
	 * Add the new wc vendors shipping module
	 *
	 * @since    1.1.0
	 * @param    array    $methods      The shipping methods array.
	 * @return   array    $methods    	The updated shipping methods array.
	*/
	public function wcvendors_pro_shipping_method( $methods ) {

		$methods[ 'wcv_pro_vendor_shipping' ] = 'WCVendors_Pro_Shipping_Method';
		return $methods;

	}

	/**
	 * WooCommerce Tools for Pro this will allow admins to import commission overrides from free.
	 *
	 * @since 1.3.6
	 * @access public
	 */
	public function wc_pro_tools( $tools ){

		$tools[ 'import_vendor_commissions' ] = array(
				'name'    => __( 'Import Vendor Commission Overrides', 'wcvendors' ),
				'button'  => __( 'Import vendor commission overrides', 'wcvendors' ),
				'desc'    => __( 'This will import all the commission overrides for vendors.', 'wcvendors' ),
				'callback' => array( 'WCVendors_Pro_Commission_Controller', 'import_vendor_commission_overrides' )
			);

		$tools[ 'import_product_commissions' ] = array(
				'name'    => __( 'Import Product Commission Overrides', 'wcvendors' ),
				'button'  => __( 'Import product commission overrides', 'wcvendors' ),
				'desc'    => __( 'This will import all the commission overrides for products.', 'wcvendors' ),
				'callback' => array( 'WCVendors_Pro_Commission_Controller', 'import_product_commission_overrides' )
			);

		return $tools;

	} // wc_pro_tools()

	/**
	 * Register front end widgets
	 *
	 * @since 1.4.4
	 */
	public function register_widgets( ){

		include_once( dirname( __FILE__ ) . '/widgets/class-wcvendors-pro-widget-store-search.php' );
		include_once( dirname( __FILE__ ) . '/widgets/class-wcvendors-pro-widget-store-categories.php' );

		register_widget( 'WCV_Widget_Store_Search' );
		register_widget( 'WCV_Widget_Store_Categories' );

	} // register_widgets


	/**
	 * Add a product edit template meta box to the product admin edit screen
	 *
	 * @since 1.4.4
	 * @access public
	 */
	public function add_template_meta_box( $post_type ){

		add_meta_box( 'wcv-wpsls-template-meta-box', __( 'Product Form Template', 'wc-vendors-wpsls'), array( $this, 'load_template_metabox' ), 'product', 'side', 'default', null );

	} // add_template_meta_box

	/**
	 * Add the content for the product template metabox on product admin edit screen
	 *
	 * @since 1.4.4
	 * @access public
	 */
	public function load_template_metabox( ){

		wp_nonce_field( basename( __FILE__ ), 'product-template-mb-nonce' );

		woocommerce_wp_select(
		array(
			'id'      => '_wcv_product_form_template',
			'label'   => __( 'Template Name', 'wpsls' ),
			'options' => WCVendors_Pro_Product_Controller::product_templates()
			)
		);

	} // load_template_metabox()

	public function save_template_product_meta( $post_id ){

		if ( !empty( $_POST[ '_wcv_product_form_template' ] ) ){
			update_post_meta( $post_id, '_wcv_product_form_template', esc_attr( $_POST[ '_wcv_product_form_template' ] ) );
		} else {
			update_post_meta( $post_id, '_wcv_product_form_template', '' );
		}

	} // save_template_product_meta()

	/**
	 * Hook into the query args for the drop down on the coupon screen.
	 *
	 * @since 1.4.5
	 * @access public
	 */
	public function vendor_dropdown_users( $args ){

		$screen       = get_current_screen();
		$screen_id    = $screen ? $screen->id : '';

		if ( 'shop_coupon' === $screen_id ){
			$vendor_args = array(
				'who'		=> '',
				'role__in'	=> array( 'vendor', 'administrator' )
			);
			$args = array_merge($args, $vendor_args);
		}

		return $args;

	} // vendor_dropdown_users

}
