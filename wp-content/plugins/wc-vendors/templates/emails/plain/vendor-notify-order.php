<?php
/**
 * Vendor new order email (plain text)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/vendor-notify-order.php.
 *
 *
 * @author		Jamie Madden, WC Vendors
 * @package 	WCvendors/Templates/Emails/Plain
 * @version		2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo "= " . $email_heading . " =\n\n";

echo sprintf( __( 'You have received an order from %s.', 'wc-vendors' ), $customer_name ) . "\n\n";

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

// Change the order details to reflect the vendor order details
do_action( 'wcvendors_email_order_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

do_action( 'wcvendors_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
