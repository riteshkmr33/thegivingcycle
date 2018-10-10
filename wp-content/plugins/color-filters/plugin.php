<?php
/*
Plugin Name: Ultimate WooCommerce Filters
Plugin URI: https://www.etoilewebdesign.com/plugins/woocommerce-filters/
Description: Filter WooCommerce products by color, size, attribute, categories and tags. Easy to implement and use WooCommerce filters.
Author: Etoile Web Design
Author URI: https://www.etoilewebdesign.com
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: color-filters
Version: 2.0.5
*/

define( 'CF_VERSION', '2.0.5' );
define( 'CF_PLUGIN_PATH', dirname( __FILE__ ) );
define( 'CF_INCLUDES_PATH', CF_PLUGIN_PATH . '/includes' );
define( 'CF_PLUGIN_FOLDER', basename( CF_PLUGIN_PATH ) );
define( 'CF_PLUGIN_URL', plugins_url() . '/' . CF_PLUGIN_FOLDER );

global $wpdb;
global $ewd_uwcf_message;
global $EWD_UWCF_Full_Version;

include "Functions/Error_Notices.php";
include "Functions/EWD_UWCF_Process_Ajax.php";
include "Functions/EWD_UWCF_Register_Taxonomies.php";
include "Functions/EWD_UWCF_Sync_Colors_Sizes_Save.php";
include "Functions/EWD_UWCF_WC_Filters_Actions.php";
include "Functions/EWD_UWCF_Widgets.php";
include "Functions/Full_Upgrade.php";
include "Functions/Output_Options.php";
include "Functions/Update_Admin_Databases.php";
include "Functions/Update_Content.php";

include "Shortcodes/Display_Filters.php";

// Install plugin
register_activation_hook( __FILE__, 'EWD_UWCF_install' );
function EWD_UWCF_install() {
	if ( get_option( 'nm_color_filters' ) != 'installed' ) {
		update_option( 'nm_color_filters', 'installed' );
	}
	
	// Register taxonomy here so that we can flush permalink rules
	EWD_UWCF_Register_Taxonomies();
	
	flush_rewrite_rules();
}

if ( is_admin() ){
	add_action('admin_menu', 'EWD_UWCF_Plugin_Menu');
	add_action('init', 'EWD_UWCF_Update_Content', 12);
	add_action('admin_notices', 'EWD_UWCF_Error_Notices');
}

function EWD_UWCF_Plugin_Menu() {
	$Enable_Colors = get_option("EWD_UWCF_Enable_Colors");
	$Enable_Sizes = get_option("EWD_UWCF_Enable_Sizes");

	$Access_Role = get_option("EWD_UWCF_Access_Role");

	if ($Access_Role == "") {$Access_Role = "administrator";}
	if (current_user_can($Access_Role)) {
		add_menu_page('Ultimate WooCommerce Filters', 'WC Filters', $Access_Role, 'EWD-UWCF-options', 'EWD_UWCF_Output_Options', null , '50.5');
		if ($Enable_Colors == "Yes") {add_submenu_page('EWD-UWCF-options', 'UWCF Colors', 'Colors', $Access_Role, 'EWD-UWCF-options&DisplayPage=Colors', 'EWD_UWCF_Output_Options');}
		if ($Enable_Sizes == "Yes") {add_submenu_page('EWD-UWCF-options', 'UWCF Sizes', 'Sizes', $Access_Role, 'EWD-UWCF-options&DisplayPage=Sizes', 'EWD_UWCF_Output_Options');}
	}
}

add_action( 'admin_enqueue_scripts', 'EWD_UWCF_Enqueue_Admin_Scripts_CSS' );
function EWD_UWCF_Enqueue_Admin_Scripts_CSS() {
	global $post, $pagenow;

	$Enable_Colors = get_option("EWD_UWCF_Enable_Colors");
	$Enable_Sizes = get_option("EWD_UWCF_Enable_Sizes");

	if ($Enable_Colors == "Yes") {
		$Colors = get_terms( array( 
					'hide_empty' => false,
					'taxonomy' => 'product_color'
		));
	
		if (!is_wp_error($Colors)) {
			foreach ($Colors as $index => $Color) {
				$Color_Value = get_term_meta($Color->term_id, 'EWD_UWCF_Color', true);
				$Colors[$index]->color = $Color_Value;
			}
		}
	}

	if ($Enable_Sizes == "Yes") {
		$Sizes = get_terms( array( 
					'hide_empty' => false,
					'taxonomy' => 'product_size'
		));
	}
		
	if ( (isset($_GET['page']) && $_GET['page'] == 'EWD-UWCF-options') || (($pagenow == 'post-new.php' || $pagenow == 'post.php')  && get_post_type( $post ) == 'product') || (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'product_color') || ($pagenow == 'edit.php' && $_GET['post_type'] == 'product')) {
		wp_enqueue_script( 'ewd-uwcf-admin-js', CF_PLUGIN_URL . '/js/Admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), CF_VERSION, true);
		if ($Enable_Colors == "Yes") {wp_localize_script( 'ewd-uwcf-admin-js', 'EWD_UWCF_Colors', $Colors );}
		if ($Enable_Sizes == "Yes") {wp_localize_script( 'ewd-uwcf-admin-js', 'EWD_UWCF_Sizes', $Sizes );}

		wp_enqueue_script( 'js_colorpicker', CF_PLUGIN_URL . '/assets/js/colorpicker.min.js' );

		wp_enqueue_style( 'css_colorpicker', CF_PLUGIN_URL . '/assets/css/colorpicker.min.css' );
		wp_enqueue_style( 'color_filters', CF_PLUGIN_URL . '/assets/css/admin.css' );
	}
}


add_action( 'wp_enqueue_scripts', 'EWD_UWCF_Enqueue_Front_End_Scripts' );
/**
* Front-end display JS & CSS.
*
*/
function EWD_UWCF_Enqueue_Front_End_Scripts() {
	$Enable_Autocomplete = get_option("EWD_UWCF_Enable_Autocomplete");
	
	$EWD_UWCF_Data = array();
	if ($Enable_Autocomplete == "Yes") {
		$EWD_UWCF_Data['Products'] = get_posts(array('post_type' => 'product', 'posts_per_page' => -1));
	}

	wp_enqueue_style( 'color-filters', CF_PLUGIN_URL . '/assets/css/color-filters.css' );
	wp_enqueue_script( 'ewd-uwcf-js', CF_PLUGIN_URL . '/js/ewd-uwcf-js.js', array('jquery'), CF_VERSION );

	wp_localize_script('ewd-uwcf-js', 'EWD_UWCF_Data', $EWD_UWCF_Data);
}

$EWD_UWCF_Full_Version = get_option("EWD_UWCF_Full_Version");

if (isset($_POST['EWD_UWCF_Upgrade_To_Full'])) {
	  add_action('admin_init', 'EWD_UWCF_Upgrade_To_Full');
}

/* Add in default options and change data structures to make them easier to work with */
if ( get_option( 'elm_color_filters_version' ) != CF_VERSION ) {
	add_action('init', 'EWD_UWCF_Option_Data_Options', 11);
}

function EWD_UWCF_Option_Data_Options() {
	global $wpdb;

	$colors = get_option('nm_taxonomy_colors');
	if (!is_array($colors)) {$colors = array();}

	$Counter = 0;
	foreach ($colors as $term_id => $color) {
		if (!get_term_meta($term_id, 'EWD_UWCF_Color', true)) {
			update_term_meta($term_id, 'EWD_UWCF_Color', $color);
		}
		if (!get_term_meta($term_id, 'EWD_UWCF_Term_Order', true)) {
			update_term_meta($term_id, 'EWD_UWCF_Term_Order', $Counter);
		}

		$Counter++;
	}

	if (get_option("EWD_UWCF_WC_Color_Attribute_WC_Field_ID") == "") {
		$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    	$wpdb->insert(
    		$wpdb->prefix . "woocommerce_attribute_taxonomies",
    		array(
    			'attribute_name' => 'ewd_uwcf_colors',
    			'attribute_label' => 'UWCF Colors',
    			'attribute_type' => 'select',
    			'attribute_orderby' => 'menu_order',
    			'attribute_public' => 0
    		)
    	);

    	$Color_Attribute_WC_Field_ID = $wpdb->insert_id;;
    	update_option("EWD_UWCF_WC_Color_Attribute_WC_Field_ID", $Color_Attribute_WC_Field_ID);

    	$get_terms = get_terms( array( 
			'hide_empty' => false,
			'taxonomy' => 'product_color'
		));

		foreach ($get_terms as $term) {
			$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->terms (name, slug) VALUES (%s, %s)", $term->name, $term->slug));
    		if ($wpdb->insert_id) {
    			$WC_Term_ID = $wpdb->insert_id;
    			$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->term_taxonomy (term_id, taxonomy) VALUES (%d, %s)", $WC_Term_ID, "pa_ewd_uwcf_colors"));
    			update_term_meta($term->term_id, 'WC_Term_ID', $WC_Term_ID);
    		}
		}

		$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    	$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM $wc_attribute_table_name order by attribute_name ASC;" );
		set_transient( 'wc_attribute_taxonomies', $attribute_taxonomies );
	}

	if (get_option("EWD_UWCF_WC_Size_Attribute_WC_Field_ID") == "") {
		$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    	$wpdb->insert(
    		$wpdb->prefix . "woocommerce_attribute_taxonomies",
    		array(
    			'attribute_name' => 'ewd_uwcf_sizes',
    			'attribute_label' => 'UWCF Sizes',
    			'attribute_type' => 'select',
    			'attribute_orderby' => 'menu_order',
    			'attribute_public' => 0
    		)
    	);

    	$Size_Attribute_WC_Field_ID = $wpdb->insert_id;;
    	update_option("EWD_UWCF_WC_Size_Attribute_WC_Field_ID", $Size_Attribute_WC_Field_ID);

    	$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM $wc_attribute_table_name order by attribute_name ASC;" );
		set_transient( 'wc_attribute_taxonomies', $attribute_taxonomies );
    }

	
	$widgets = get_option("widget_nm_color_filters");
	if (!is_array($widgets)) {$widgets = array();}
	foreach ($widgets as $widget) {
		if (isset($widget['layout'])) {
			if ($widget['layout'] == 'color_and_text' or $widget['layout'] == 'text') {$Show_Text = "Yes";}
			else {$Show_Text = "No";}
			if ($widget['layout'] == 'color_and_text' or $widget['layout'] == 'color') {$Show_Color = "Yes";}
			else {$Show_Color = "No";}
			if ($widget['hide_empty']) {$Hide_Empty = "Yes";}
			else {$Hide_Empty = "No";}
			if ($widget['product_count']) {$Show_Product_Count = "Yes";}
			else {$Show_Product_Count = "No";}

			break;
		}
	}

	if (!isset($Show_Text)) {$Show_Text = "Yes";}
	if (!isset($Show_Color)) {$Show_Color = "Yes";}
	if (!isset($Hide_Empty)) {$Hide_Empty = "Yes";}
	if (!isset($Show_Product_Count)) {$Show_Product_Count = "Yes";}

	if (get_option("EWD_UWCF_Full_Version") == "") {update_option("EWD_UWCF_Full_Version", "No");}

	if (get_option("EWD_UWCF_Enable_Colors") == "") {update_option("EWD_UWCF_Enable_Colors", "Yes");}
	if (get_option("EWD_UWCF_Color_Filters_Display") == "") {update_option("EWD_UWCF_Color_Filters_Display", "List");}
	if (get_option("EWD_UWCF_Color_Filters_Show_Text") == "") {update_option("EWD_UWCF_Color_Filters_Show_Text", $Show_Text);}
	if (get_option("EWD_UWCF_Color_Filters_Show_Color") == "") {update_option("EWD_UWCF_Color_Filters_Show_Color", $Show_Color);}
	if (get_option("EWD_UWCF_Color_Filters_Hide_Empty") == "") {update_option("EWD_UWCF_Color_Filters_Hide_Empty", $Hide_Empty);}
	if (get_option("EWD_UWCF_Color_Filters_Show_Product_Count") == "") {update_option("EWD_UWCF_Color_Filters_Show_Product_Count", $Show_Product_Count);}
	if (get_option("EWD_UWCF_Display_Thumbnail_Colors") == "") {update_option("EWD_UWCF_Display_Thumbnail_Colors", 'No');}
	if (get_option("EWD_UWCF_Colors_Product_Page_Display") == "") {update_option("EWD_UWCF_Colors_Product_Page_Display", 'No');}
	if (get_option("EWD_UWCF_Colors_Used_For_Variations") == "") {update_option("EWD_UWCF_Colors_Used_For_Variations", 'No');}
	
	if (get_option("EWD_UWCF_Enable_Sizes") == "") {update_option("EWD_UWCF_Enable_Sizes", "Yes");}
	if (get_option("EWD_UWCF_Size_Filters_Display") == "") {update_option("EWD_UWCF_Size_Filters_Display", "List");}
	if (get_option("EWD_UWCF_Size_Filters_Show_Text") == "") {update_option("EWD_UWCF_Size_Filters_Show_Text", "Yes");}
	if (get_option("EWD_UWCF_Size_Filters_Hide_Empty") == "") {update_option("EWD_UWCF_Size_Filters_Hide_Empty", "Yes");}
	if (get_option("EWD_UWCF_Size_Filters_Show_Product_Count") == "") {update_option("EWD_UWCF_Size_Filters_Show_Product_Count", "Yes");}
	if (get_option("EWD_UWCF_Display_Thumbnail_Sizes") == "") {update_option("EWD_UWCF_Display_Thumbnail_Sizes", 'No');}
	if (get_option("EWD_UWCF_Sizes_Product_Page_Display") == "") {update_option("EWD_UWCF_Sizes_Product_Page_Display", 'No');}
	if (get_option("EWD_UWCF_Sizes_Used_For_Variations") == "") {update_option("EWD_UWCF_Sizes_Used_For_Variations", 'No');}

	if (get_option("EWD_UWCF_Enable_Categories") == "") {update_option("EWD_UWCF_Enable_Categories", "No");}
	if (get_option("EWD_UWCF_Category_Filters_Display") == "") {update_option("EWD_UWCF_Category_Filters_Display", "List");}
	if (get_option("EWD_UWCF_Category_Filters_Show_Text") == "") {update_option("EWD_UWCF_Category_Filters_Show_Text", "Yes");}
	if (get_option("EWD_UWCF_Category_Filters_Hide_Empty") == "") {update_option("EWD_UWCF_Category_Filters_Hide_Empty", "Yes");}
	if (get_option("EWD_UWCF_Category_Filters_Show_Product_Count") == "") {update_option("EWD_UWCF_Category_Filters_Show_Product_Count", "Yes");}
	if (get_option("EWD_UWCF_Display_Thumbnail_Categories") == "") {update_option("EWD_UWCF_Display_Thumbnail_Categories", 'No');}

	if (get_option("EWD_UWCF_Enable_Tags") == "") {update_option("EWD_UWCF_Enable_Tags", "No");}
	if (get_option("EWD_UWCF_Tag_Filters_Display") == "") {update_option("EWD_UWCF_Tag_Filters_Display", "List");}
	if (get_option("EWD_UWCF_Tag_Filters_Show_Text") == "") {update_option("EWD_UWCF_Tag_Filters_Show_Text", "Yes");}
	if (get_option("EWD_UWCF_Tag_Filters_Hide_Empty") == "") {update_option("EWD_UWCF_Tag_Filters_Hide_Empty", "Yes");}
	if (get_option("EWD_UWCF_Tag_Filters_Show_Product_Count") == "") {update_option("EWD_UWCF_Tag_Filters_Show_Product_Count", "Yes");}
	if (get_option("EWD_UWCF_Display_Thumbnail_Tags") == "") {update_option("EWD_UWCF_Display_Thumbnail_Tags", 'No');}

	if (get_option("EWD_UWCF_Enable_Text_Search") == "") {update_option("EWD_UWCF_Enable_Text_Search", 'No');}
	if (get_option("EWD_UWCF_Enable_Autocomplete") == "") {update_option("EWD_UWCF_Enable_Autocomplete", 'No');}
	
	if (get_option("EWD_UWCF_Access_Role") == "") {update_option("EWD_UWCF_Access_Role", "administrator");}

	if (get_option("EWD_UWCF_Color_Filters_Color_Shape") == "") {update_option("EWD_UWCF_Color_Filters_Color_Shape", "Circle");}

	update_option( 'elm_color_filters_version', CF_VERSION );
}