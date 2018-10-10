<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>

<?php if ( $show_shipping ) { ?>
<div class="col3-set">
<?php } else { ?>
<div class="col2-set">
<?php } ?>
	<div class="col-1">
		<div class="box-inner">
			<header><h2><?php _e( 'Customer Details', 'buddyboss-marketplace' ); ?></h2></header>

			<table class="shop_table customer_details">
				<?php if ( $order->get_customer_note() ) : ?>
					<tr>
						<th><?php _e( 'Note:', 'buddyboss-marketplace' ); ?></th>
						<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
					</tr>
				<?php endif; ?>

				<?php if ( $order->get_billing_email() ) : ?>
					<tr>
						<th><?php _e( 'Email:', 'buddyboss-marketplace' ); ?></th>
						<td><?php echo esc_html( $order->get_billing_email() ); ?></td>
					</tr>
				<?php endif; ?>

				<?php if ( $order->get_billing_phone() ) : ?>
					<tr>
						<th><?php _e( 'Telephone:', 'buddyboss-marketplace' ); ?></th>
						<td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
					</tr>
				<?php endif; ?>

				<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
			</table>
		</div>
	</div>


	<div class="col-2">
		<div class="box-inner">
			<header class="title">
				<h3><?php _e( 'Billing Address', 'buddyboss-marketplace' ); ?></h3>
			</header>
			<address>
				<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'buddyboss-marketplace' ); ?>
			</address>
		</div>
	</div>

	<?php if ( $show_shipping ) : ?>

		<div class="col-3">
			<div class="box-inner">
				<header class="title">
					<h3><?php _e( 'Shipping Address', 'buddyboss-marketplace' ); ?></h3>
				</header>
				<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'woocommerce' ) ) ); ?>
				</address>
			</div>
		</div><!-- /.col-3 -->

	<?php endif; ?>

</div>

