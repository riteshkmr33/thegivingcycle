<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

?>
<p class="woocommerce-result-count">
    <?php
    $paged    = max( 1, $wp_query->get( 'paged' ) );
    $per_page = $wp_query->get( 'posts_per_page' );
    $total    = $wp_query->found_posts;
    $first    = ( $per_page * $paged ) - $per_page + 1;
    $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
    $cat = isset($_GET['cate'])?$_GET['cate']:'';
    $from = "";
    if($cat) {
        $cat = get_term_by( 'slug', $cat, 'product_cat' );
    } else {
        $cat = $wp_query->get_queried_object();
    }

    $from = ( $cat->label ) ? $cat->label :
            ( ( $cat->name ) ? $cat->name : __( 'Showing', 'buddyboss-marketplace' ) );

    if ( 1 == $total ) {
        printf( __( '%1s (1 of 1)', 'buddyboss-marketplace' ), $from );
    } elseif ( $total <= $per_page || -1 == $per_page ) {
        printf( __( '%1s (%2$d)', 'buddyboss-marketplace' ), $from, $total );
    } else {
        printf( _x( '%1s (%2$d&ndash;%3$d of %4$d)', '%1s = $from, %2$d = first, %3$d = last, %4$d = total', 'buddyboss-marketplace' ), $from, $first, $last, $total );
    }
    ?>
</p>