<?php
/**
 * The template for displaying the store settings form
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/
 *
 * @package    WCVendors_Pro
 * @version    1.5.0
 */

$settings_social 		= (array) get_option( 'wcvendors_hide_settings_social' );
$social_total = count( $settings_social );
$social_count = 0;
foreach ( $settings_social as $value) { if ( 1 == $value ) $social_count +=1;  }

?>

<h3><?php _e( 'Settings', 'wcvendors-pro' ); ?></h3>

<?php do_action( 'wcvendors_settings_before_form' ); ?>

<form method="post" id="wcv-store-settings" action="#" class="wcv-form">

<?php WCVendors_Pro_Store_Form::form_data(); ?>

<div class="wcv-tabs top" data-prevent-url-change="true">

	<?php WCVendors_Pro_Store_Form::store_form_tabs( ); ?>

	<!-- Store Settings Form -->

	<div class="tabs-content" id="store">

		<!-- Store Name -->
		<?php BuddyBoss_BM_Templates::store_name( $store_name ); ?>

		<?php do_action( 'wcvendors_settings_after_shop_name' ); ?>

		<!-- Store Description -->
		<?php WCVendors_Pro_Store_Form::store_description( $store_description ); ?>

		<?php do_action( 'wcvendors_settings_after_shop_description' ); ?>
		<br />

		<!-- Seller Info -->
		<?php WCVendors_Pro_Store_Form::seller_info( ); ?>


		<?php do_action( 'wcvendors_settings_after_seller_info' ); ?>

		<br />

		<div class="bm-field-groups">
		<!-- Company URL -->
        <?php do_action( 'wcvendors_settings_before_company_url' ); ?>
		<?php WCVendors_Pro_Store_Form::company_url( ); ?>
        <?php do_action(  'wcvendors_settings_after_company_url' ); ?>
		</div>

		<div class="bm-field-groups">
		<!-- Store Phone -->
        <?php do_action( 'wcvendors_settings_before_store_phone' ); ?>
		<?php WCVendors_Pro_Store_Form::store_phone( ); ?>
        <?php do_action(  'wcvendors_settings_after_store_phone' ); ?>
		</div>

		<!-- Store Address -->
		<?php do_action( 'wcvendors_settings_before_address' ); ?>
		<?php WCVendors_Pro_Store_Form::store_address_country( ); ?>
		<?php WCVendors_Pro_Store_Form::store_address1( ); ?>
		<?php WCVendors_Pro_Store_Form::store_address2( ); ?>
		<?php WCVendors_Pro_Store_Form::store_address_city( ); ?>
		<?php WCVendors_Pro_Store_Form::store_address_state( ); ?>
		<?php WCVendors_Pro_Store_Form::store_address_postcode( ); ?>
		<?php do_action(  'wcvendors_settings_after_address' ); ?>

		<!-- Store Vacation Mode -->
		<?php do_action( 'wcvendors_settings_before_vacation_mode' ); ?>
		<?php WCVendors_Pro_Store_Form::vacation_mode( ); ?>
		<?php do_action(  'wcvendors_settings_after_vacation_mode' ); ?>


	</div>

	<div class="tabs-content" id="payment">
		<!-- Paypal address -->
		<?php do_action( 'wcvendors_settings_before_paypal' ); ?>

		<?php WCVendors_Pro_Store_Form::paypal_address( ); ?>

		<?php WCVendors_Pro_Store_Form::bank_account_name( ); ?>
		<?php WCVendors_Pro_Store_Form::bank_account_number( ); ?>
		<?php WCVendors_Pro_Store_Form::bank_name( ); ?>
		<?php WCVendors_Pro_Store_Form::bank_routing_number( ); ?>
		<?php WCVendors_Pro_Store_Form::bank_iban( ); ?>
		<?php WCVendors_Pro_Store_Form::bank_bic_swift( ); ?>

		<?php do_action( 'wcvendors_settings_after_paypal' ); ?>
	</div>

	<div class="tabs-content" id="branding">

		<?php do_action( 'wcvendors_settings_before_branding' ); ?>

		<?php
		// Settings page options

		if ( 'yes' != get_option( 'wcvendors_hide_settings_branding_store_banner' ) ): ?>
		<h6><?php _e( 'Store Banner', 'buddyboss-marketplace'); ?></h6>
		<div class="file-upload-wrap banner">
			<?php BuddyBoss_BM_Templates::store_banner( ); ?>
		</div>
		<?php endif; ?>

		<?php if ( 'yes' != get_option( 'wcvendors_hide_settings_branding_store_icon' ) ): ?>
		<!-- Store Icon -->
		<h6><?php _e( 'Store Icon', 'buddyboss-marketplace'); ?></h6>
		<div class="file-upload-wrap icon">
			<?php BuddyBoss_BM_Templates::store_icon( ); ?>
		</div>
		<?php endif; ?>

		<?php do_action( 'wcvendors_settings_after_branding' ); ?>
	</div>

	<div class="tabs-content" id="shipping">

		<?php do_action( 'wcvendors_settings_before_shipping' ); ?>

		<!-- Shipping Rates -->
		<?php WCVendors_Pro_Store_Form::shipping_rates( ); ?>

		<?php do_action( 'wcvendors_settings_after_shipping' ); ?>

		<hr />

		<?php WCVendors_Pro_Store_Form::order_min_charge( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::order_max_charge( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::free_shipping_order( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::product_max_charge( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::free_shipping_product( $shipping_details ); ?>

		<!-- Shiping Information  -->

		<?php WCVendors_Pro_Store_Form::product_handling_fee( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::shipping_policy( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::return_policy( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::shipping_from( $shipping_details ); ?>
		<?php WCVendors_Pro_Store_Form::shipping_address( $shipping_details ); ?>

	</div>

	<?php if ( $social_count != $social_total ) :  ?>
		<div class="tabs-content" id="social">
			<?php do_action( 'wcvendors_settings_before_social' ); ?>
			<!-- Twitter -->
			<?php WCVendors_Pro_Store_Form::twitter_username( ); ?>
			<!-- Instagram -->
			<?php WCVendors_Pro_Store_Form::instagram_username( ); ?>
			<!-- Facebook -->
			<?php WCVendors_Pro_Store_Form::facebook_url( ); ?>
			<!-- Linked in -->
			<?php WCVendors_Pro_Store_Form::linkedin_url( ); ?>
			<!-- Youtube URL -->
			<?php WCVendors_Pro_Store_Form::youtube_url( ); ?>
			<!-- Pinterest URL -->
			<?php WCVendors_Pro_Store_Form::pinterest_url( ); ?>
			<!-- Google+ URL -->
			<?php WCVendors_Pro_Store_Form::googleplus_url( ); ?>
			<!-- Snapchat -->
			<?php WCVendors_Pro_Store_Form::snapchat_username( ); ?>
			<?php do_action(  'wcvendors_settings_after_social' ); ?>
		</div>
	<?php endif; ?>

	<!-- Store SEO -->
	<div class="tabs-content" id="seo">
		<?php do_action( 'wcvendors_settings_before_seo' ); ?>
		<!-- SEO Title -->
		<?php WCVendors_Pro_Store_Form::seo_title( ); ?>
		<!-- Meta description -->
		<?php WCVendors_Pro_Store_Form::seo_meta_description( ); ?>
		<!-- Meta keywords -->
		<?php WCVendors_Pro_Store_Form::seo_meta_keywords( ); ?>
		<!-- Facebook title -->
		<?php WCVendors_Pro_Store_Form::seo_fb_title( ); ?>
		<!-- Facebook description -->
		<?php WCVendors_Pro_Store_Form::seo_fb_description( ); ?>
		<!-- Facebook image  -->
		<?php WCVendors_Pro_Store_Form::seo_fb_image( ); ?>
		<!-- Twitter Title -->
		<?php WCVendors_Pro_Store_Form::seo_twitter_title( ); ?>
		<!-- Twitter Description -->
		<?php WCVendors_Pro_Store_Form::seo_twitter_description( ); ?>
		<!-- Twitter Image -->
		<?php WCVendors_Pro_Store_Form::seo_twitter_image( ); ?>

		<?php do_action( 'wcvendors_settings_after_seo' ); ?>
	</div>
		<!-- Submit Button -->
		<!-- DO NOT REMOVE THE FOLLOWING TWO LINES -->
		<?php WCVendors_Pro_Store_Form::save_button( __( 'Save Changes', 'wcvendors-pro') ); ?>
</div>
	</form>
<?php do_action( 'wcvendors_settings_after_form' );
