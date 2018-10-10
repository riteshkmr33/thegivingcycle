<?php

/**
 * @package WordPress
 * @subpackage BuddyBoss MarketPlace
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

if ( ! class_exists( 'BuddyBoss_BM_Products' ) ):

    /**
     *
     * BuddyBoss_BM_Products
     * ********************
     *
     *
     */
    class BuddyBoss_BM_Products {

        /**
         * The single instance of the class.
         *
         * @var BuddyBoss_BM_Products
         */
        protected static $_instance = null;

        /**
         * empty constructor function to ensure a single instance
         */
        public function __construct() {
            // leave empty, see singleton below
        }

        /**
         * BuddyBoss_BM_Products Instance.
         *
         * Ensures only one instance of BuddyBoss_BM_Products is loaded or can be loaded.
         *
         * @return BuddyBoss_BM_Products - instance.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
                self::$_instance->setup();
            }
            return self::$_instance;
        }

        /**
         * Setup all
         */
        public function setup() {
            $this->templates = array();

            add_action( 'bp_setup_nav', array( $this, 'bm_setup_nav' ), 100 );
            add_action( 'bp_setup_admin_bar', array( $this, 'bm_setup_admin_bar' ), 80 );

        }

        public function bm_setup_nav() {
            $displayed_user_id = bp_displayed_user_id();

            $products_default_screen_function = 'bm_user_favorites';
            $products_default_subnav = 'favorite-products';
            $count = '';

            if(WCV_Vendors::is_vendor( $displayed_user_id )) {
                $products_default_screen_function = 'bm_user_products';
                $products_default_subnav = 'my_products';
                // Get products count for the displayed user
                $count = count_user_posts( $displayed_user_id, 'product', true );
            }

            bp_core_new_nav_item( array(
                'name' => sprintf( __( 'Products <span class="count">%s</span>', 'buddyboss-marketplace' ), $count ),
                'slug' => 'products',
                'screen_function' => $products_default_screen_function,
                'position' => 60,
                'default_subnav_slug' => $products_default_subnav
            ) );

            $user_domain = ( ! empty( $displayed_user_id ) ) ? bp_displayed_user_domain() : bp_loggedin_user_domain();

            $products_link = trailingslashit( $user_domain . 'products' );

            if(WCV_Vendors::is_vendor( $displayed_user_id )) {
                // Add subnav items
                bp_core_new_subnav_item(array(
                    'name' => __('Products', 'buddyboss-marketplace'),
                    'slug' => 'my_products',
                    'parent_url' => $products_link,
                    'parent_slug' => 'products',
                    'screen_function' => 'bm_user_products',
                    'position' => 10,
                ));
            }

            // Add subnav items
            bp_core_new_subnav_item( array(
                'name' => __( 'Favorite Products', 'buddyboss-marketplace' ),
                'slug' => 'favorite-products',
                'parent_url' => $products_link,
                'parent_slug' => 'products',
                'screen_function' => 'bm_user_favorites',
                'position' => 20,
            ) );

            // Add subnav items
            bp_core_new_subnav_item( array(
                'name' => __( 'Favorite Shops', 'buddyboss-marketplace' ),
                'slug' => 'favorite-shops',
                'parent_url' => $products_link,
                'parent_slug' => 'products',
                'screen_function' => 'bm_user_shops',
                'position' => 30,
            ) );

            $default_screen = 'bm_screen_history';

            bp_core_new_nav_item( array(
                'name' => apply_filters('bp_shop_link_label', __('Orders', 'buddyboss-marketplace')),
                'slug' => 'orders',
                'screen_function' => $default_screen,
                'position' => 70,
                'show_for_displayed_user' => false,
                'default_subnav_slug' => 'history'
            ) );

            $shop_link = trailingslashit($user_domain . 'orders');

            // Add subnav items
            bp_core_new_subnav_item( array(
                'name' => apply_filters('bp_history_link_label', __('History', 'buddyboss-marketplace')),
                'slug' => 'history',
                'parent_url' => $shop_link,
                'parent_slug' => 'orders',
                'screen_function' => 'bm_screen_history',
                'position' => 10,
                'item_css_id' => 'shop-history',
                'user_has_access' => bp_is_my_profile()
            ) );

            // Add subnav items
            bp_core_new_subnav_item( array(
                'name' => apply_filters('bp_track_order_link_label', __('Track your order', 'buddyboss-marketplace')),
                'slug' => 'track',
                'parent_url' => $shop_link,
                'parent_slug' => 'orders',
                'screen_function' => 'bm_screen_track_order',
                'position' => 20,
                'item_css_id' => 'shop-track',
                'user_has_access' => bp_is_my_profile()
            ) );

        }

        /**
         * Adds the user's navigation in WP Admin Bar
         */
        public function bm_setup_admin_bar( $wp_admin_nav = array() ) {
            global $wp_admin_bar;
            $displayed_user_id = get_current_user_id();

            $base_url = bp_loggedin_user_domain().'products';
            $my_products_url = $base_url.'/my_products';
            $favorite_products_url = $base_url.'/favorite-products';
            $main_url = $favorite_products_url;
            if(WCV_Vendors::is_vendor( $displayed_user_id )) {
                $main_url = $my_products_url;
            }
            $favorite_shops_url = $base_url.'/favorite-shops';

            $orders_url = bp_loggedin_user_domain().'orders';
            $track_order = $orders_url.'/track';

            // Menus for logged in user
            if ( is_user_logged_in() ) {

                $wp_admin_bar->add_menu( array(
                    'parent' => 'my-account-buddypress',
                    'id' => 'my-account-products',
                    'title' => __( 'Products', 'buddyboss-marketplace' ),
                    'href' => trailingslashit( $main_url )
                ) );

                if(WCV_Vendors::is_vendor( $displayed_user_id )) {
                    $wp_admin_bar->add_menu(array(
                        'parent' => 'my-account-products',
                        'id' => 'my-account-products-' . 'products',
                        'title' => __('Products', 'buddyboss-marketplace'),
                        'href' => trailingslashit($my_products_url)
                    ));
                }

                // Add add-new submenu
                $wp_admin_bar->add_menu( array(
                    'parent' => 'my-account-products',
                    'id'     => 'my-account-products-'.'favorite-products',
                    'title'  => __( 'Favorite Products', 'buddyboss-marketplace' ),
                    'href'   => trailingslashit( $favorite_products_url )
                ) );

                // Add add-new submenu
                $wp_admin_bar->add_menu( array(
                    'parent' => 'my-account-products',
                    'id'     => 'my-account-products-'.'favorite-shops',
                    'title'  => __( 'Favorite Shops', 'buddyboss-marketplace' ),
                    'href'   => trailingslashit( $favorite_shops_url )
                ) );

                $wp_admin_bar->add_menu( array(
                    'parent' => 'my-account-buddypress',
                    'id' => 'my-account-orders',
                    'title' => __( 'Orders', 'buddyboss-marketplace' ),
                    'href' => trailingslashit( $orders_url )
                ) );

                $wp_admin_bar->add_menu( array(
                    'parent' => 'my-account-orders',
                    'id' => 'my-account-orders-history',
                    'title' => __( 'History', 'buddyboss-marketplace' ),
                    'href' => trailingslashit( $orders_url )
                ) );

                $wp_admin_bar->add_menu( array(
                    'parent' => 'my-account-orders',
                    'id' => 'my-account-orders-track',
                    'title' => __( 'Track your order', 'buddyboss-marketplace' ),
                    'href' => trailingslashit( $track_order )
                ) );

            }
        }

    }

    // End class BuddyBoss_BM_Products

    BuddyBoss_BM_Products::instance();


endif;