<?php
/**
 * BuddyBoss MarketPlace - User Products
 *
 * @package WordPress
 * @subpackage BuddyBoss MarketPlace
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $paged;

$vendor_id 			= bp_displayed_user_id();
$shop_url  = WCV_Vendors::get_vendor_shop_page( $vendor_id );
$paged = bp_action_variable( 1 );
$paged = $paged ? $paged : 1;
$favorites = get_user_meta($vendor_id, "favorite_products", true);
?>
<div class="woocommerce">
<?php
    if(!empty($favorites)):
        $product_args = array(
            'post_type'       => 'product',
            'post__in' => $favorites,
            'paged' => $paged
        );

        $product_posts = new WP_Query( $product_args );
        ?>

        <?php if ( $product_posts->have_posts() ) : ?>

            <?php
            /**
             * woocommerce_before_shop_loop hook
             *
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action( 'woocommerce_before_shop_loop' );
            ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php woocommerce_product_subcategories(); ?>

            <?php while ( $product_posts->have_posts() ) : $product_posts->the_post(); ?>

                <?php wc_get_template_part( 'content', 'product' ); ?>

            <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            /**
             * woocommerce_after_shop_loop hook
             *
             * @hooked woocommerce_pagination - 10
             */
            //do_action( 'woocommerce_after_shop_loop' );
            ?>

            <nav class="woocommerce-pagination">
                <?php

                 $url = remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ));

                if (strpos($url, '/products/') === false) {
                    $url = str_replace('/page', '/products/favorite-products/page', $url);
                } else if (strpos($url, '/favorite-products/') === false) {
                    $url = str_replace('/page', '/favorite-products/page', $url);
                }

                echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
                    'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', $url ) ) ),
                    'format'       => '',
                    'add_args'     => '',
                    'current'      => max( 1, $paged ),
                    'total'        => $product_posts->max_num_pages,
                    'prev_text'    => '&larr;',
                    'next_text'    => '&rarr;',
                    'type'         => 'list',
                    'end_size'     => 3,
                    'mid_size'     => 3
                ) ) );
                ?>
            </nav>

        <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

            <div id="message" class="info">
                <p><?php _e( "Sorry, no favorite products were found.", 'buddyboss-marketplace' ); ?></p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
<?php else: ?>
        <div id="message" class="info">
            <p><?php _e( "Sorry, no favorite products were found.", 'buddyboss-marketplace' ); ?></p>
        </div>
    </div>
<?php endif; ?>
