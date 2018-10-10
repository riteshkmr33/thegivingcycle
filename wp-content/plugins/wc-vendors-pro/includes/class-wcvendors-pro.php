<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/includes
 * @author     Jamie Madden <support@wcvendors.com>
 */
class WCVendors_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WCVendors_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wcvendors_pro    The string used to uniquely identify this plugin.
	 */
	protected $wcvendors_pro;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Is the plugin base directory
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $base_dir  string path for the plugin directory
	 */
	private $base_dir;

	/**
	 * Is the plugin in debug mode
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $debug    plugin is in debug mode
	 */
	private $debug;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->wcvendors_pro = 'wcvendors-pro';
		$this->version = WCV_PRO_VERSION;
		$this->debug = false;

		$this->load_dependencies();
		$this->set_locale();

		add_action( 'admin_init', array( $this, 'check_install' ) );

		// Admin Objects
		$this->wcvendors_pro_admin = new WCVendors_Pro_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_commission_controller = new WCVendors_Pro_Commission_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_shipping_controller = new WCVendors_Pro_Shipping_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_admin_vendor_controller = new WCVendors_Pro_Admin_Vendor_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );

		// Public Objects
		$this->wcvendors_pro_public = new WCVendors_Pro_Public( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_dashboard = new WCVendors_Pro_Dashboard( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_product_controller = new WCVendors_Pro_Product_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_order_controller = new WCVendors_Pro_Order_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_shop_coupon_controller = new WCVendors_Pro_Shop_Coupon_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );
		$this->wcvendors_pro_report_controller = new WCVendors_Pro_Reports_Controller( $this->wcvendors_pro, $this->version, $this->get_debug()  );
		$this->wcvendors_pro_vendor_controller = new WCVendors_Pro_Vendor_Controller( $this->wcvendors_pro, $this->version, $this->get_debug()  );
		$this->wcvendors_pro_product_form = new WCVendors_Pro_Product_Form( $this->wcvendors_pro, $this->version, $this->get_debug() );
		$this->wcvendors_pro_store_form = new WCVendors_Pro_Store_Form( $this->wcvendors_pro, $this->version, $this->get_debug() );

		// Shared Objects
		$this->wcvendors_pro_ratings_controller = new WCVendors_Pro_Ratings_Controller( $this->get_plugin_name(), $this->get_version(), $this->get_debug() );

		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shared_hooks();

	}

	/**
	* Deactivate pro if WC Vendors 2.0.0 isn't found.
	*
	*/
	public function check_install(){

		require_once( 'wcv-functions.php' );
		if ( version_compare( WCV_VERSION, '2.0.0', '<') ){
			deactivate_plugins( WCV_PRO_PLUGIN_FILE );
			add_action( 'admin_notices', 'wcvendors_2_required_notice' );
		}

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WCVendors_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - WCVendors_Pro_i18n. Defines internationalization functionality.
	 * - WCVendors_Pro_Admin. Defines all hooks for the dashboard.
	 * - WCVendors_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-activator.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-i18n.php';

		/**
		 *  A utility class for use throughout the plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-utils.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcvendors-pro-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcvendors-pro-commission-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcvendors-pro-shipping-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcvendors-pro-admin-vendor-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcvendors-pro-admin-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wcv-admin-functions.php';


		/**
		 *  The classes that are shared between both admin and public
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-ratings-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-product-dropdown-walker.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcvendors-pro-product-category-checklist.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/walkers/class-wcvendors-pro-store-cat-list-walker.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wcv-update-functions.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wcv-update-functions.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-form-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-table-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-dashboard.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-product-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-order-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-vendor-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-shop-coupon-controller.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcvendors-pro-reports-controller.php';

		/**
		 *   All forms for the public facing side
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/forms/class-wcvendors-pro-store-form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/forms/class-wcvendors-pro-tracking-number-form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/forms/class-wcvendors-pro-coupon-form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/forms/class-wcvendors-pro-product-form.php';

		$this->loader = new WCVendors_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WCVendors_Pro_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WCVendors_Pro_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->wcvendors_pro . '.php' );
		$shipping_disabled		= 'yes' === get_option( 'wcvendors_shipping_management_cap' ) ? true : false;

		// Installer & Update

		$this->loader->add_action( 'init', 									'WCVendors_Pro_Activator', 'init_background_updater' );
		$this->loader->add_action( 'admin_init', 							'WCVendors_Pro_Activator', 'install_actions' );
		$this->loader->add_action( 'admin_init', 							'WCVendors_Pro_Activator', 'check_version' );

		// Register admin actions
		$this->loader->add_action( 'admin_enqueue_scripts',					$this->wcvendors_pro_admin, 'enqueue_scripts' );

		// Add product edit template to edit screen
		$this->loader->add_action( 'add_meta_boxes', 						$this->wcvendors_pro_admin, 'add_template_meta_box' );
		$this->loader->add_action( 'woocommerce_process_product_meta', 		$this->wcvendors_pro_admin, 'save_template_product_meta' );

		// Store Widgets
		$this->loader->add_action( 'widgets_init', 							$this->wcvendors_pro_admin, 'register_widgets' );

		$this->loader->add_action( 'init', 									$this->wcvendors_pro_admin, 'admin_lockout' );

		$this->loader->add_action( 'woocommerce_system_status_report', 		$this->wcvendors_pro_admin, 'wcvendors_pro_system_status' );
		$this->loader->add_action( 'woocommerce_system_status_report', 		$this->wcvendors_pro_admin, 'wcvendors_pro_template_status' );

		$this->loader->add_filter( 'woocommerce_debug_tools',				$this->wcvendors_pro_admin, 'wc_pro_tools' );
		$this->loader->add_filter( 'wp_dropdown_users_args',				$this->wcvendors_pro_admin, 'vendor_dropdown_users' );

		// @todo replace this with the plugin_basename once work out how to correct the path to wcvendors-pro instead of wc-vendors-pro
		$this->loader->add_action( 'plugin_action_links_'. $plugin_basename, 	$this->wcvendors_pro_admin, 	'add_action_links' );

		$this->loader->add_filter( 'wcv_commission_rate', 					$this->wcvendors_pro_commission_controller, 'process_commission', 10, 5 );
		// $this->loader->add_action( 'wcvendors_shipping_due' , 				$this->wcvendors_pro_commission_controller, 'get_shipping_due', 10, 4 );
		$this->loader->add_action( 'wcvendors_shipping_due' , 				$this->wcvendors_pro_commission_controller, 'get_shipping_due_from_order', 10, 5 );

		// Product Meta Commission Tab
		// disable free commission tabs
		$this->loader->add_filter( 'wcv_product_commission_tab' , 			$this->wcvendors_pro_commission_controller, 	'update_product_meta' );
		$this->loader->add_action( 'woocommerce_product_write_panel_tabs', 	$this->wcvendors_pro_commission_controller,  	'add_commission_tab' );
		$this->loader->add_action( 'woocommerce_product_data_panels', 		$this->wcvendors_pro_commission_controller,  	'add_commission_panel' );
		$this->loader->add_action( 'woocommerce_process_product_meta', 		$this->wcvendors_pro_commission_controller,  	'save_commission_panel' );

		// Vendor Commission Overrides
		$this->loader->add_action( 'show_user_profile', 					$this->wcvendors_pro_commission_controller,  	'store_commission_meta_fields', 11 );
		$this->loader->add_action( 'edit_user_profile', 					$this->wcvendors_pro_commission_controller,  	'store_commission_meta_fields', 11 );
		$this->loader->add_action( 'personal_options_update', 				$this->wcvendors_pro_commission_controller,  	'store_commission_meta_fields_save', 11 );
		$this->loader->add_action( 'edit_user_profile_update', 				$this->wcvendors_pro_commission_controller,  	'store_commission_meta_fields_save', 11 );

		// Vendor Controller
		$this->loader->add_action( 'edit_user_profile', 					$this->wcvendors_pro_admin_vendor_controller, 	'add_pro_vendor_meta_fields', 11 );
		$this->loader->add_action( 'show_user_profile', 					$this->wcvendors_pro_admin_vendor_controller, 	'add_pro_vendor_meta_fields', 11 );

		$this->loader->add_action( 'personal_options_update', 				$this->wcvendors_pro_admin_vendor_controller, 	'save_pro_vendor_meta_fields' );
		$this->loader->add_action( 'edit_user_profile_update', 				$this->wcvendors_pro_admin_vendor_controller, 	'save_pro_vendor_meta_fields' );
		$this->loader->add_action( 'restrict_manage_posts', 				$this->wcvendors_pro_admin_vendor_controller, 	'restrict_manage_posts', 12 );
		$this->loader->add_filter( 'parse_query', 							$this->wcvendors_pro_admin_vendor_controller, 	'vendor_filter_query' );

		// Check shipping capability.
		if ( ! $shipping_disabled ) {

			// Shipping calculator
			$this->loader->add_action( 'woocommerce_shipping_init',		$this->wcvendors_pro_admin, 'wcvendors_pro_shipping_init' );
			$this->loader->add_filter( 'woocommerce_shipping_methods',	$this->wcvendors_pro_admin, 'wcvendors_pro_shipping_method' );

			// Shipping Controller
			$this->loader->add_action( 'woocommerce_product_tabs', 				$this->wcvendors_pro_shipping_controller, 	'shipping_panel_tab', 11, 2 );


			// Store Shipping Override for User Meta
			$this->loader->add_action( 'personal_options_update', 				$this->wcvendors_pro_shipping_controller,  	'save_vendor_shipping_user', 11 );
			$this->loader->add_action( 'edit_user_profile_update', 				$this->wcvendors_pro_shipping_controller,  	'save_vendor_shipping_user', 11 );
			$this->loader->add_action( 'edit_user_profile', 					$this->wcvendors_pro_shipping_controller, 	'add_pro_vendor_meta_fields', 11 );
			$this->loader->add_action( 'show_user_profile', 					$this->wcvendors_pro_shipping_controller, 	'add_pro_vendor_meta_fields', 11 );
			$this->loader->add_action( 'wcv_admin_after_shipping_flat_rate', 	$this->wcvendors_pro_shipping_controller,  	'add_pro_vendor_country_rate_fields', 11 );

			// Shipping Product edit
			$this->loader->add_action( 'woocommerce_product_options_shipping', 	$this->wcvendors_pro_shipping_controller,  	'product_vendor_shipping_panel' );
			$this->loader->add_action( 'woocommerce_process_product_meta', 		$this->wcvendors_pro_shipping_controller, 	'save_vendor_shipping_product' );

			// Cart and checkout
			$this->loader->add_filter( 'woocommerce_cart_shipping_packages', 			$this->wcvendors_pro_shipping_controller,	'vendor_split_woocommerce_cart_shipping_packages' );
			$this->loader->add_filter( 'woocommerce_shipping_package_name', 			$this->wcvendors_pro_shipping_controller,	'rename_vendor_shipping_package', 10, 3 );
			$this->loader->add_filter( 'woocommerce_cart_shipping_method_full_label', 	$this->wcvendors_pro_shipping_controller, 	'rename_vendor_shipping_method_label', 10, 2 );

		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$shipping_disabled		= 'yes' == get_option( 'wcvendors_shipping_management_cap' ) ? true : false;
		$pro_store_header		= get_option( 'wcvendors_vendor_store_header_type' );
		$shop_store_header		= 'yes' == get_option( 'wcvendors_store_shop_headers' ) ? true : false;
		$single_store_header	= 'yes' == get_option( 'wcvendors_store_single_headers' ) ? true : false;
		$single_product_tools	= 'yes' == get_option( 'wcvendors_single_product_tools' ) ? true : false;

		// Public Class
		$this->loader->add_action( 'wp_enqueue_scripts', 			$this->wcvendors_pro_public, 		'enqueue_styles' 	);
		$this->loader->add_action( 'wp_enqueue_scripts', 			$this->wcvendors_pro_public, 		'enqueue_scripts' 	);
		$this->loader->add_filter( 'body_class', 					$this->wcvendors_pro_public, 		'body_class' 		);


		// WCVendors Pro Dashboard
		$this->loader->add_action( 'template_redirect', 			$this->wcvendors_pro_dashboard, 	'check_permission' );
		$this->loader->add_action( 'wcv_pro_after_dashboard_nav', 	$this->wcvendors_pro_dashboard, 	'lock_new_products_notice' );

		// Dashboard Rewrite rule filters
		$this->loader->add_filter( 'query_vars', 				$this->wcvendors_pro_dashboard, 'add_query_vars' );
		$this->loader->add_filter( 'rewrite_rules_array', 		$this->wcvendors_pro_dashboard, 'rewrite_rules' );
		$this->loader->add_shortcode( 'wcv_pro_dashboard', 		$this->wcvendors_pro_dashboard, 'load_dashboard' );
		$this->loader->add_shortcode( 'wcv_pro_dashboard_nav',  $this->wcvendors_pro_dashboard, 'load_dashboard_nav' );

		// Product controller
		$this->loader->add_action( 'template_redirect', 						$this->wcvendors_pro_product_controller, 	'process_submit' );
		$this->loader->add_action( 'template_redirect', 						$this->wcvendors_pro_product_controller, 	'process_delete' );
		$this->loader->add_action( 'template_redirect', 						$this->wcvendors_pro_product_controller, 	'process_duplicate' );

		// File upload limits code
		$this->loader->add_filter( 'wp_handle_upload_prefilter', 				$this->wcvendors_pro_product_controller, 	'filter_upload' );
		$this->loader->add_action( 'pre_get_posts', 							$this, 'filter_product_search_query' );
		$this->loader->add_filter( 'wcv_product_gallery_options', 				$this->wcvendors_pro_product_form, 	'product_max_gallery_count' );

		// Product Display table
		$this->loader->add_filter( 'wcvendors_pro_table_row_args_product',		$this->wcvendors_pro_product_controller, 'product_search_args' );
		$this->loader->add_filter( 'wcvendors_pro_table_columns_product', 		$this->wcvendors_pro_product_controller, 'table_columns' );
		$this->loader->add_filter( 'wcvendors_pro_table_rows_product',	 		$this->wcvendors_pro_product_controller, 'table_rows', 10, 2 );
		$this->loader->add_filter( 'wcvendors_pro_table_action_column_product',	$this->wcvendors_pro_product_controller, 'table_action_column' );
		$this->loader->add_filter( 'wcvendors_pro_table_before_product',		$this->wcvendors_pro_product_controller, 'table_actions' );
		$this->loader->add_filter( 'wcvendors_pro_table_after_product',			$this->wcvendors_pro_product_controller, 'table_actions' );
		$this->loader->add_filter( 'wcvendors_pro_table_post_per_page_product',	$this->wcvendors_pro_product_controller, 'table_posts_per_page' );
		$this->loader->add_filter( 'wcvendors_pro_table_no_data_notice_product',$this->wcvendors_pro_product_controller, 'table_no_data_notice' );

		// Product AJAX calls
		$this->loader->add_action( 'wp_ajax_wcv_json_search_products', 				$this->wcvendors_pro_product_controller, 'json_search_products' );
		$this->loader->add_action( 'wp_ajax_wcv_json_search_tags', 					$this->wcvendors_pro_product_controller, 'json_search_product_tags' );
		$this->loader->add_action( 'wp_ajax_wcv_json_add_attribute', 				$this->wcvendors_pro_product_controller, 'json_add_attribute' );
		$this->loader->add_action( 'wp_ajax_wcv_json_add_new_attribute', 			$this->wcvendors_pro_product_controller, 'json_add_new_attribute' );
		$this->loader->add_action( 'wp_ajax_wcv_json_default_variation_attributes', $this->wcvendors_pro_product_controller, 'json_default_variation_attributes' );
		$this->loader->add_action( 'wp_ajax_wcv_json_load_variation', 				$this->wcvendors_pro_product_controller, 'json_load_variations' );
		$this->loader->add_action( 'wp_ajax_wcv_json_add_variation', 				$this->wcvendors_pro_product_controller, 'json_add_variation' );
		$this->loader->add_action( 'wp_ajax_wcv_json_link_all_variations', 			$this->wcvendors_pro_product_controller, 'json_link_all_variations' );

		// Orders controller
		$this->loader->add_filter( 'wcvendors_pro_table_columns_order', 			$this->wcvendors_pro_order_controller, 'table_columns' );
		$this->loader->add_filter( 'wcvendors_pro_table_rows_order',	 			$this->wcvendors_pro_order_controller, 'table_rows', 10, 2 );
		$this->loader->add_filter( 'wcvendors_pro_table_action_column_order',		$this->wcvendors_pro_order_controller, 	'table_action_column' );
		$this->loader->add_filter( 'wcvendors_pro_table_before_order',				$this->wcvendors_pro_order_controller, 	'table_actions' );
		$this->loader->add_filter( 'wcvendors_pro_table_no_data_notice_order', 	 	$this->wcvendors_pro_order_controller,  'table_no_data_notice' );
		$this->loader->add_action( 'template_redirect', 							$this->wcvendors_pro_order_controller, 	'process_submit' );
		$this->loader->add_action( 'template_redirect', 							$this, 	'wc_filter_address_hook' );
		$this->loader->add_filter( 'woocommerce_order_item_get_formatted_meta_data',	$this->wcvendors_pro_order_controller, 	'filter_order_item_get_formatted_meta_data', 10, 2 );

		// Shop Coupon controller
		$this->loader->add_action( 'template_redirect',								$this->wcvendors_pro_shop_coupon_controller, 	'process_submit' );
		$this->loader->add_action( 'template_redirect', 							$this->wcvendors_pro_shop_coupon_controller, 	'process_delete' );

		// Shop coupon table
		$this->loader->add_filter( 'wcvendors_pro_table_columns_shop_coupon', 		$this->wcvendors_pro_shop_coupon_controller, 	'table_columns' );
		$this->loader->add_filter( 'wcvendors_pro_table_rows_shop_coupon',	 		$this->wcvendors_pro_shop_coupon_controller, 	'table_rows', 10, 2 );
		$this->loader->add_filter( 'wcvendors_pro_table_actions_shop_coupon',	 	$this->wcvendors_pro_shop_coupon_controller, 	'table_row_actions' );
		$this->loader->add_filter( 'wcvendors_pro_table_action_column_shop_coupon',	$this->wcvendors_pro_shop_coupon_controller, 	'table_action_column' );
		$this->loader->add_filter( 'wcvendors_pro_table_before_shop_coupon',		$this->wcvendors_pro_shop_coupon_controller, 	'table_actions' );
		$this->loader->add_filter( 'wcvendors_pro_table_after_shop_coupon',			$this->wcvendors_pro_shop_coupon_controller, 	'table_actions' );
		$this->loader->add_filter( 'wcvendors_pro_table_post_per_page_shop_coupon',	$this->wcvendors_pro_shop_coupon_controller, 	'table_posts_per_page' );
		$this->loader->add_filter( 'wcvendors_pro_table_no_data_notice_shop_coupon',$this->wcvendors_pro_shop_coupon_controller, 	'table_no_data_notice' );

		$this->loader->add_filter( 'manage_shop_coupon_posts_columns', 				$this->wcvendors_pro_shop_coupon_controller, 	'display_vendor_store_column', 15 );
		$this->loader->add_action( 'manage_shop_coupon_posts_custom_column', 		$this->wcvendors_pro_shop_coupon_controller, 	'display_vendor_store_custom_column', 2, 99 );

		// Reports
		$this->loader->add_action( 'template_redirect', 								$this->wcvendors_pro_report_controller, 	'process_submit' );
		$this->loader->add_filter( 'wcvendors_pro_table_no_data_notice_recent_product',	$this->wcvendors_pro_report_controller, 	'product_table_no_data_notice' );
		$this->loader->add_filter( 'wcvendors_pro_table_no_data_notice_recent_order',	$this->wcvendors_pro_report_controller, 	'order_table_no_data_notice' );

		// Vendor Controller
		$this->loader->add_filter( 'wp_head',  									$this->wcvendors_pro_vendor_controller, 	'storefront_seo' );
		$this->loader->add_filter( 'woocommerce_login_redirect',  				$this->wcvendors_pro_vendor_controller, 	'vendor_login_redirect', 10, 2 );
		$this->loader->add_action( 'woocommerce_created_customer', 				$this->wcvendors_pro_vendor_controller, 	'apply_vendor_redirect', 10, 2 );
		$this->loader->add_action( 'template_redirect', 						$this->wcvendors_pro_vendor_controller, 	'process_submit' );
		$this->loader->add_action( 'woocommerce_before_my_account', 			$this->wcvendors_pro_vendor_controller, 	'pro_dashboard_link_myaccount' );
		$this->loader->add_shortcode( 'wcv_pro_vendorslist', 					$this->wcvendors_pro_vendor_controller, 	'vendors_list' );
		$this->loader->add_action( 'wp_enqueue_scripts', 						$this->wcvendors_pro_vendor_controller, 	'wcvendors_list_scripts' );
		$this->loader->add_action( 'wp_ajax_wcv_json_unique_store_name', 			$this->wcvendors_pro_vendor_controller, 	'json_unique_store_name' );

		// Store query filters
		$this->loader->add_action( 'pre_get_posts', 						$this->wcvendors_pro_vendor_controller, 	'vendor_store_search_where', 99 );
		$this->loader->add_action( 'pre_get_posts', 						$this->wcvendors_pro_vendor_controller, 	'vendor_store_category_filter', 99 );

		if ( 'pro' === $pro_store_header  ) {

			// Disable free shop headers
			add_filter( 'wcvendors_disable_shop_headers', function () {return false; });

			if ( $shop_store_header ){

				$this->loader->add_action( 'woocommerce_before_main_content',		$this->wcvendors_pro_vendor_controller, 	'store_main_content_header', 30 );
				$this->loader->add_action( 'wcv_after_vendor_store_header',			$this->wcvendors_pro_vendor_controller, 	'vacation_mode' );

				if ( $single_store_header ) {
					$this->loader->add_action( 'woocommerce_before_single_product',		$this->wcvendors_pro_vendor_controller, 	'store_single_header');
				} else {
					$this->loader->add_action( 'woocommerce_before_single_product',		$this->wcvendors_pro_vendor_controller, 	'vacation_mode');
				}
			} else {
				$this->loader->add_action( 'woocommerce_before_main_content',			$this->wcvendors_pro_vendor_controller, 	'vacation_mode', 30);
			}
		}

		if ( ! $shipping_disabled ){
			$this->loader->add_action( 'woocommerce_product_meta_start', 		$this->wcvendors_pro_vendor_controller, 	'product_ships_from', 9 );
		}

		// Single product page vendor tools
		if ( $single_product_tools ){
			$this->loader->add_action( 'woocommerce_product_meta_start', 		$this->wcvendors_pro_vendor_controller, 	'enable_vendor_tools', 8 );
		}

	}


	/**
	 * Register all of the hooks related to shared functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shared_hooks() {

		// Settings 'yes' === get_option( 'wcvendors_capability_product_delete') ? true: false;
		$ratings_disabled		= 'yes' === get_option( 'wcvendors_ratings_management_cap' ) ? true: false;
		$pro_store_header		= 'yes' === get_option( 'wcvendors_vendor_store_header_type' ) ? true: false;

		// Filter all uploads to include an md5 of the guid.
		$this->loader->add_filter( 'wp_update_attachment_metadata', 'WCVendors_Pro', 'add_md5_to_attachment', 10, 2);


		if ( !$ratings_disabled ) {

			// ADMIN
			$this->loader->add_action( 'admin_menu', 			$this->wcvendors_pro_ratings_controller, 	'admin_page_setup', 60 );
			$this->loader->add_filter( 'init', 					$this->wcvendors_pro_ratings_controller, 	'process_form_submission' );
			$this->loader->add_filter( 'rewrite_rules_array', 	$this->wcvendors_pro_ratings_controller, 	'add_rewrite_rules' );
			$this->loader->add_filter( 'query_vars', 			$this->wcvendors_pro_ratings_controller, 	'add_query_vars' );
			$this->loader->add_action( 'admin_enqueue_scripts', $this->wcvendors_pro_ratings_controller, 	'enqueue_scripts' );
			$this->loader->add_action( 'admin_enqueue_scripts', $this->wcvendors_pro_ratings_controller, 	'enqueue_styles' );

			// PUBLIC
			$this->loader->add_filter( 'wcvendors_pro_table_columns_rating', 		$this->wcvendors_pro_ratings_controller, 'table_columns' );
			$this->loader->add_filter( 'wcvendors_pro_table_rows_rating',	 		$this->wcvendors_pro_ratings_controller, 'table_rows' );
			$this->loader->add_filter( 'wcvendors_pro_table_action_column_rating',	$this->wcvendors_pro_ratings_controller, 'table_action_column' );
			$this->loader->add_filter( 'wcvendors_pro_table_no_data_notice_rating', $this->wcvendors_pro_ratings_controller, 'table_no_data_notice' );
			$this->loader->add_action( 'template_redirect', 						$this->wcvendors_pro_ratings_controller, 'display_vendor_ratings' );
			$this->loader->add_action( 'woocommerce_product_tabs', 					$this->wcvendors_pro_ratings_controller, 'vendor_ratings_panel_tab' );
			$this->loader->add_shortcode( 'wcv_feedback', 							$this->wcvendors_pro_ratings_controller, 'wcv_feedback' );

			//  Display the link to view the ratings in both headers
			if ( ! $pro_store_header ) {
				$this->loader->add_action( 'wcv_after_main_header', $this->wcvendors_pro_ratings_controller, 	'ratings_link' );
				$this->loader->add_action( 'wcv_after_mini_header', $this->wcvendors_pro_ratings_controller, 	'ratings_link' );
			}

			$this->loader->add_filter( 'woocommerce_my_account_my_orders_actions', 		$this->wcvendors_pro_ratings_controller, 	'feedback_link_action', 10, 3 );
			$this->loader->add_shortcode( 'wcv_feedback_form', 		$this->wcvendors_pro_ratings_controller, 	'feedback_form' );
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->wcvendors_pro;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WCVendors_Pro_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the debug status of the plugin.
	 *
	 * @since     1.0.0
	 * @return    bool    The debug status of the plugin.
	 */
	public function get_debug() {
		return $this->debug;
	}

	/**
	 * Get Option wrapper for WC Vendors calls
	 *
	 * @since     1.0.0
	 * @return    mixed    The option requested from the main options system.
	*/
	public static function get_option( $option = '' ) {

		$mappings =wcv_get_settings_mapping();

		if ( array_key_exists( $option, $mappings ) ){
			return get_option( $mappings[ $option ] );
		} else {
			get_option( $option );
		}

	} // get_option()


	/**
	 * Get the plugin path
	 *
	 * @since     1.0.0
	 * @return    string    The path to the plugin dir
	*/
	public static function get_path( ){

		return plugin_dir_path( dirname( __FILE__ ) );

	} // get_path()

	/**
	 * Class logger so that we can keep our debug and logging information cleaner
	 *
	 * @since 1.4.0
	 * @version 1.4.4
	 * @access public
	 *
	 * @param mixed - $data the data to go to the error log could be string, array or object
	 */
	public static function log( $data = '', $prefix = '' ){

		$trace 		= debug_backtrace( false, 2 );
		$caller 	= ( isset( $trace[ 1 ]['class'] ) ) ? $trace[ 1 ]['class'] : basename( $trace[ 1 ][ 'file' ] );

		if ( is_array( $data ) || is_object( $data ) ) {
			if ( $prefix ){
				error_log( '===========================' );
				error_log( $prefix );
				error_log( '===========================' );
			}
			error_log( $caller . ' : ' . print_r( $data, true ) );
		} else {
			if ( $prefix ){
				error_log( '===========================' );
				error_log( $prefix );
				error_log( '===========================' );
			}
			error_log( $caller  . ' : ' . $data );
		}

	} // log()

	/**
	 * Filter the WooCommerce shipping and billing addresses on the pro dashboard to show and hide options
	 *
	 * @since 1.3.6
	 * @access public
	 */
	public function wc_filter_address_hook() {

		$dashboard_page_id 		= get_option( 'wcvendors_dashboard_page_id' );

		if ( isset( $dashboard_page_id ) ) {
			// Dashboard page or the shipping label page
			if ( is_page( $dashboard_page_id ) || ( isset( $_GET['wcv_shipping_label' ] ) ) ){
				add_filter( 'woocommerce_order_formatted_shipping_address',	array( $this->wcvendors_pro_order_controller, 	'filter_formatted_shipping_address' ) );
				add_filter( 'woocommerce_order_formatted_billing_address',	array( $this->wcvendors_pro_order_controller, 	'filter_formatted_billing_address' ) );
			}
		}

	} // wc_shipping_address_hook()


	/**
	* Hook into the pre_get_posts to modify the search
	*
	* @since 1.5.0
	*/
	public function filter_product_search_query( $query ){

		$current_page_id = get_the_ID();
		$dashboard_page_id 	= get_option( 'wcvendors_dashboard_page_id' );

		if ( $current_page_id != $dashboard_page_id ) return;

		if( $search = $query->get( '_wcv_product_search' ) ) {

	        add_filter( 'get_meta_sql', function( $sql ) use ( $search ){
	            global $wpdb;

	            // Only run once:
	            static $nr = 0;
	            if( 0 != $nr++ ) return $sql;

	            // Modified WHERE
	            $sql[ 'where'] = sprintf(
	                " AND ( %s OR %s ) ",
	                $wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $search ),
	                mb_substr( $sql[ 'where' ], 5, mb_strlen( $sql[ 'where' ] ) )
	            );

	            return $sql;
	        });
	    }
	}

	/**
	*--------------------------------------------------------------------------
	* WC Vendors Pro settings
	*--------------------------------------------------------------------------
	*
	* These methods return which front end components are enabled for WC Vendors Pro
	*
	*/


	/**
	 *  Check if the vendor shipping method is enabled in woocommerce settings
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function is_vendor_shipping_method_enabled(){

		$shipping_methods 			= WC()->shipping() ? WC()->shipping->load_shipping_methods() : array();
		$shipping_method_enabled	= ( array_key_exists('wcv_pro_vendor_shipping', $shipping_methods ) && $shipping_methods['wcv_pro_vendor_shipping']->enabled == 'yes' ) ? true : false;

		return $shipping_method_enabled;

	} // is_vendor_shipping_method_enabled()

	/**
	 * This function fires when an attachment is uploaded in wp-admin and will generate an md5 of the post GUID.
	 *
	 * @since 1.3.9
	 * @access public
	 */
	public static function add_md5_to_attachment( $meta_data, $post_id ){

		WCVendors_Pro::md5_attachment_url( $post_id );

		// Return original Meta data
		return $meta_data;

	} // add_md5_to_attachment()

	/**
	 * This function will add an md5 hash of the file url ( post GUID ) on attachment post types.
	 *
	 * @since 1.3.9
	 * @access public
	 */
	public static function md5_attachment_url( $post_id ){

		// Add an MD5 of the GUID for later queries.
		if ( !$attachment_post = get_post( $post_id ) )
			return false;

		update_post_meta( $attachment_post->ID, '_md5_guid', md5( $attachment_post->guid ) );

	} // md5_upload_attachment

	/**
	 * This function will return the md5 hash of an attachment post if the id is
	 *
	 * @since 1.3.9
	 * @access public
	 * @return int $attachment_id
	 */
	public static function get_attachment_id( $md5_guid ){

		global $wpdb;
		// Get the attachment_id from the database
		$attachment_id = $wpdb->get_var( "select post_id from $wpdb->postmeta where meta_key = '_md5_guid' AND meta_value ='$md5_guid'" );

		return $attachment_id;

	} // get_attachment_id

} // WCVendors_Pro
