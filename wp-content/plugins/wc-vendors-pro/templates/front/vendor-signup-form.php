<?php
/**
 * The template for displaying the vendor application form
 *
 * Override this template by copying it to yourtheme/wc-vendors/front
 *
 * @package    WCVendors_Pro
 * @version    1.5.0
 */
?>
<form method="post" id="wcv-store-settings" action="" class="wcv-form wcv-formvalidator">

	<?php WCVendors_Pro_Store_Form::sign_up_form_data(); ?>

	<h3><?php _e( 'Vendor Application', 'wcvendors-pro'); ?></h3>

	<div class="wcv-signupnotice">
		<?php echo $vendor_signup_notice; ?>
	</div>

	<br />

	<div class="wcv-tabs top" data-prevent-url-change="true">

		<?php WCVendors_Pro_Store_Form::store_form_tabs( ); ?>

		<!-- Store Settings Form -->
		<div class="tabs-content" id="store">

			<!-- Store Name -->
			<?php WCVendors_Pro_Store_Form::store_name( '' ); ?>

			<?php do_action( 'wcvendors_settings_after_shop_name' ); ?>

			<!-- Store Description -->
			<?php WCVendors_Pro_Store_Form::store_description( '' ); ?>

			<?php do_action( 'wcvendors_settings_after_shop_description' ); ?>
			<br />

			<!-- Seller Info -->
			<?php WCVendors_Pro_Store_Form::seller_info( ); ?>


			<?php do_action( 'wcvendors_settings_after_seller_info' ); ?>

			<br />

			<!-- Company URL -->
			<?php do_action( 'wcvendors_signup_before_company_url' ); ?>
			<?php WCVendors_Pro_Store_Form::company_url( ); ?>
			<?php do_action( 'wcvendors_signup_after_company_url' ); ?>

			<!-- Store Phone -->
			<?php do_action( 'wcvendors_signup_before_store_phone' ); ?>
			<?php WCVendors_Pro_Store_Form::store_phone( ); ?>
			<?php do_action( 'wcvendors_signup_after_store_phone' ); ?>

			<!-- Store Address -->
			<?php do_action( 'wcvendors_signup_before_address' ); ?>
			<?php WCVendors_Pro_Store_Form::store_address_country( ); ?>
			<?php WCVendors_Pro_Store_Form::store_address1( ); ?>
			<?php WCVendors_Pro_Store_Form::store_address2( ); ?>
			<?php WCVendors_Pro_Store_Form::store_address_city( ); ?>
			<?php WCVendors_Pro_Store_Form::store_address_state( ); ?>
			<?php WCVendors_Pro_Store_Form::store_address_postcode( ); ?>
			<?php do_action(  'wcvendors_signup_after_address' ); ?>

		</div>

		<div class="tabs-content" id="payment">
			<!-- Paypal address -->
			<?php do_action( 'wcvendors_signup_before_paypal' ); ?>

			<?php WCVendors_Pro_Store_Form::paypal_address( ); ?>

			<!-- Bank Account  -->
			<?php WCVendors_Pro_Store_Form::bank_account_name( ); ?>
			<?php WCVendors_Pro_Store_Form::bank_account_number( ); ?>
			<?php WCVendors_Pro_Store_Form::bank_name( ); ?>
			<?php WCVendors_Pro_Store_Form::bank_routing_number( ); ?>
			<?php WCVendors_Pro_Store_Form::bank_iban( ); ?>
			<?php WCVendors_Pro_Store_Form::bank_bic_swift( ); ?>

			<?php do_action( 'wcvendors_signup_after_paypal' ); ?>
		</div>


	<div class="tabs-content" id="branding">
		<?php do_action( 'wcvendors_signup_before_branding' ); ?>
		<?php WCVendors_Pro_Store_Form::store_banner( ); ?>

		<!-- Store Icon -->
		<?php WCVendors_Pro_Store_Form::store_icon( ); ?>
		<?php do_action( 'wcvendors_signup_after_branding' ); ?>
	</div>

	<div class="tabs-content" id="shipping">

		<?php do_action( 'wcvendors_settings_before_shipping' ); ?>

		<!-- Shipping Rates -->
		<?php WCVendors_Pro_Store_Form::shipping_rates( ); ?>

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

		<?php do_action( 'wcvendors_settings_after_shipping' ); ?>

	</div>

	<div class="tabs-content" id="social">
		<?php do_action( 'wcvendors_signup_before_social' ); ?>
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
		<?php do_action(  'wcvendors_signup_after_social' ); ?>
	</div>

	<!-- Store SEO -->
	<div class="tabs-content" id="seo">
		<?php do_action( 'wcvendors_signup_before_seo' ); ?>
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

		<?php do_action( 'wcvendors_signup_after_seo' ); ?>
	</div>

</div>

	<!-- Terms and Conditions -->
	<?php WCVendors_Pro_Store_Form::vendor_terms(); ?>

	<!-- Submit Button -->
	<!-- DO NOT REMOVE THE FOLLOWING TWO LINES -->
	<?php WCVendors_Pro_Store_Form::save_button( __( 'Apply to be Vendor', 'wcvendors-pro') ); ?>

</form>
