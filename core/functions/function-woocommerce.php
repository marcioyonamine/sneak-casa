<?php


/*-----------------------------------------------------------------------------------*/
/* Woocommerce Hooks */
/*-----------------------------------------------------------------------------------*/ 
	
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


if ( suevafree_setting ('suevafree_woocommerce_cross_sell_cart') == "on" ) :
	
	add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
	
endif;
	
if ( suevafree_setting ('suevafree_woocommerce_related_products') == "off" ) :
	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	
endif;

if ( suevafree_setting ('suevafree_woocommerce_upsell_products') == "off" ) :
	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
	
endif;

/*-----------------------------------------------------------------------------------*/
/* Woocommerce remove breadcrumbs */
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'suevafree_remove_breadcrumbs' ) ) {

	function suevafree_remove_breadcrumbs() {
    	
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	
	}

	add_action( 'init', 'suevafree_remove_breadcrumbs' );

}

/*-----------------------------------------------------------------------------------*/
/* Woocommerce header cart */
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'suevafree_header_cart' ) ) {

	function suevafree_header_cart() {

		if ( suevafree_is_woocommerce_active() && ( !suevafree_setting('suevafree_woocommerce_header_cart') || suevafree_setting('suevafree_woocommerce_header_cart') == "on" ) ) :
		
	?>

            <div class="header-cart">
            
                <a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart','suevafree' ); ?>">
                    <i class="fa fa-shopping-cart"></i>
					<span class="cart-count"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->cart_contents_count, 'suevafree' ), WC()->cart->cart_contents_count ); ?></span>  
                </a>
                            
                <div class="header-cart-widget">
                
                    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                
                </div>
                
            </div>
    
	<?php

		endif;

	}
	
}

if ( ! function_exists( 'suevafree_cart_link_fragment' ) ) {

	function suevafree_cart_link_fragment( $fragments ) {
	
		ob_start();

?>
		<a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart','suevafree' ); ?>">
            <i class="fa fa-shopping-cart"></i>
			<span class="cart-count"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->cart_contents_count, 'suevafree' ), WC()->cart->cart_contents_count ); ?></span>  
		</a>
        
<?php

		$fragments['a.cart-contents'] = ob_get_clean();
		
		return $fragments;
	
	}
	
	add_filter( 'woocommerce_add_to_cart_fragments', 'suevafree_cart_link_fragment' );

}

/*-----------------------------------------------------------------------------------*/
/* Woocommerce before content */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_woocommerce_before_main_content')) {

	function suevafree_woocommerce_before_main_content() { 
	
		if ( is_product() ) {
			
			$classes = "product-wrapper" ;
	
		} else {
	
			$classes = "product-wrapper products-list" ;
	
		}

		do_action( 'suevafree_top_sidebar', 'top-sidebar-area');
		do_action( 'suevafree_header_sidebar', 'header-sidebar-area');
		
?>
	
	<div class="container">
	
		<div class="row">
		
			<div class="<?php echo suevafree_template('span') . " " . suevafree_template('sidebar') . " " . $classes; ?>" >
	
<?php
	
	}
	
	add_action('woocommerce_before_main_content', 'suevafree_woocommerce_before_main_content', 10);

}

/*-----------------------------------------------------------------------------------*/
/* Woocommerce after content */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_woocommerce_after_main_content')) {
	
	function suevafree_woocommerce_after_main_content() { ?>
	
			</div>
			
			<?php 
			
				if ( suevafree_template('span') == "col-md-8" ) :

					do_action('suevafree_side_sidebar', 'side-sidebar-area' );
					
				endif;
				
			?>
	
		</div>
		
	</div>

<?php

		do_action( 'suevafree_full_sidebar', 'full-sidebar-area');

	}
	
	add_action('woocommerce_after_main_content', 'suevafree_woocommerce_after_main_content', 10);

}

?>