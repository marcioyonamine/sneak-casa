<?php
/**
 * Checkout coupon form
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! WC()->cart->coupons_enabled() ) {
    return;
}

?>

<div class="coupon-form-checkout">

    <p class="coupon_link">
   
        <?php echo apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon? ', 'suevafree' ) . '<a href="#" class="showcoupon"> ' . esc_html__( 'Click here to enter your code', 'suevafree' ) . '</a>' ); ?>
   
    </p>

    <form class="checkout_coupon" method="post" >

        <p class="form-row form-row-wide">
            <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_html_e( 'Coupon code', 'suevafree' ); ?>" id="coupon_code" value="" />
        </p>

        <p class="form-row form-row-wide input-button">
            <input type="submit" class="button" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'suevafree' ); ?>" />
        </p>

        <div class="clear"></div>
    
    </form>

</div>