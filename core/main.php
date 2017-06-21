<?php

/**
 * Wp in Progress
 * 
 * @package Wordpress
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * It is also available at this URL: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/*-----------------------------------------------------------------------------------*/
/* Woocommerce is active */
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'suevafree_is_woocommerce_active' ) ) {
	
	function suevafree_is_woocommerce_active( $type = "" ) {
	
        global $woocommerce;

        if ( isset( $woocommerce ) ) {
			
			if ( !$type || call_user_func($type) ) {
            
				return true;
			
			}
			
		}
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* TAG TITLE */
/*-----------------------------------------------------------------------------------*/  

if ( ! function_exists( '_wp_render_title_tag' ) ) {

	function suevafree_title( $title, $sep ) {
		
		global $paged, $page;
	
		if ( is_feed() )
			return $title;
	
		$title .= get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
		
		if ( $paged >= 2 || $page >= 2 )	
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'suevafree' ), max( $paged, $page ) );

		return $title;
		
	}

	add_filter( 'wp_title', 'suevafree_title', 10, 2 );

	function suevafree_add_title() {
		
?>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php

	}

	add_action( 'wp_head', 'suevafree_add_title' );

}

/*-----------------------------------------------------------------------------------*/
/* IS SINGLE */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_is_single')) {

	function suevafree_is_single() {
		
		if ( is_single() || is_page() || is_singular('portfolio') ) :
		
			return true;
		
		endif;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* GET ARCHIVE TITLE */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_get_the_archive_title')) {

	function suevafree_get_archive_title() {
		
		if ( is_category() ) {
			$title = sprintf( esc_html__( 'Category: %s', 'suevafree' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( 'Tag: %s', 'suevafree' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( 'Author: %s', 'suevafree' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Year: %s', 'suevafree' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'suevafree' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Month: %s', 'suevafree' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'suevafree' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Day: %s', 'suevafree' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'suevafree' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = esc_html_x( 'Asides', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = esc_html_x( 'Galleries', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = esc_html_x( 'Images', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = esc_html_x( 'Videos', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = esc_html_x( 'Quotes', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = esc_html_x( 'Links', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = esc_html_x( 'Statuses', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = esc_html_x( 'Audio', 'post format archive title', 'suevafree' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = esc_html_x( 'Chats', 'post format archive title', 'suevafree' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( esc_html__( 'Archives: %s', 'suevafree' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			$title = sprintf( esc_html__( '%1$s: %2$s', 'suevafree' ), $tax->labels->singular_name, single_term_title( '', false ) );
		}
	
		if ( isset($title) )  :
			return $title;
		else:
			return false;
		endif;
		
	}

}

/*-----------------------------------------------------------------------------------*/
/* Theme settings */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_setting')) {

	function suevafree_setting($id, $default = '' ) {
	
		$suevafree_setting = get_theme_mod($id);
		
		if($suevafree_setting):
		
			return $suevafree_setting;
		
		else:
		
			return $default;
		
		endif;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* Post meta */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_postmeta')) {

	function suevafree_postmeta( $id, $default = '' ) {
	
		global $post, $wp_query;
		
		if (suevafree_is_woocommerce_active('is_shop')) :
	
			$content_ID = get_option('woocommerce_shop_page_id');
	
		else :
	
			$content_ID = $post->ID;
	
		endif;

		$val = get_post_meta( $content_ID , $id, TRUE);
		
		if ( !empty($val) ) :
			
			return $val;
			
		else:
				
			return $default;
			
		endif;
		
	}

}

/*-----------------------------------------------------------------------------------*/
/* REQUIRE */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_require')) {

	function suevafree_require($folder) {
	
		if (isset($folder)) : 
		
			$dir = get_template_directory() . $folder ;  
				
			$files = scandir($dir);  
				  
			foreach ($files as $key => $value) {  

				if ( !in_array($value,array(".DS_Store",".","..") ) && !strstr( $value, '._' ) ) { 
						
					if ( !is_dir( $dir . $value) ) { 
							
						require_once $dir . $value;
						
					} 
					
				} 

			}  
				
		
		endif;
		
	}

}

/*-----------------------------------------------------------------------------------*/
/* SCRIPTS */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_enqueue_script')) {

	function suevafree_enqueue_script($folder) {
	
		if ( isset($folder) ) : 
	
			$dir = get_template_directory() . $folder ;  
				
			$files = scandir($dir);  
				  
			foreach ($files as $key => $value) {  

				if ( !in_array($value,array(".DS_Store",".","..") ) && !strstr( $value, '._' ) ) { 
						
					if ( !is_dir( $dir . $value ) && strstr ( $value, 'js' )) { 
							
						wp_enqueue_script( 'suevafree-' . str_replace('.js','',$value), get_template_directory_uri() . $folder . "/" . $value , array('jquery'), FALSE, TRUE ); 
						
					} 
					
				} 

			}  

		endif;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* STYLES */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_enqueue_style')) {

	function suevafree_enqueue_style($folder) {
	
		if (isset($folder)) : 
	
			$dir = get_template_directory() . $folder ;  
				
			$files = scandir($dir);  
				  
			foreach ($files as $key => $value) {  

				if ( !in_array($value,array(".DS_Store",".","..") ) && !strstr( $value, '._' ) ) { 
						
					if ( !is_dir( $dir . $value ) && strstr ( $value, 'css' )) { 
						
						wp_enqueue_style( 'suevafree-' . str_replace('.css','',$value), get_template_directory_uri() . $folder . "/" . $value ); 
						
					} 
					
				} 

			}  
			
		endif;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/*RESPONSIVE EMBED */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_embed_html')) {
	
	function suevafree_embed_html( $html ) {
		return '<div class="embed-container">' . $html . '</div>';
	}
	 
	add_filter( 'embed_oembed_html', 'suevafree_embed_html', 10, 3 );
	add_filter( 'video_embed_html', 'suevafree_embed_html' );
	
}

/*-----------------------------------------------------------------------------------*/
/* BODY CLASSES */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_body_classes_function')) {

	function suevafree_body_classes_function($classes) {

		global $wp_customize;

		if ( isset( $wp_customize ) ) :

			$classes[] = 'customizer_active';
				
		endif;

		if ( suevafree_setting('suevafree_menu_layout') == "menubar" ) :
				
			$classes[] = 'menubar';
	
		endif;

		if ( suevafree_setting('suevafree_header_layout') == "header_layout_2" ) :
				
			$classes[] = 'scroll_header';
	
		endif;

		if ( suevafree_setting('suevafree_view_footer') == "off" ) :
				
			$classes[] = 'hide_footer';
	
		endif;

		if ( suevafree_setting('suevafree_readmore_layout') == "sneak" ) :
				
			$classes[] = 'sneak_button';
	
		endif;

		if ( suevafree_setting('suevafree_body_layout') == "minimal" ) :
				
			$classes[] = 'minimal_layout';
	
		endif;
		
		if ( suevafree_setting('suevafree_footer_layout') <> '' ) :
				
			$classes[] = suevafree_setting('suevafree_footer_layout');
	
		endif;
		
		if ( suevafree_setting('suevafree_thumb_triangle') == "on" ) :
				
			$classes[] = 'thumb_triangle_off';
	
		endif;

		if ( suevafree_setting('suevafree_thumb_hover') == "on" ) :
				
			$classes[] = 'thumb_hover_off';
	
		endif;
		
		if ( suevafree_setting('suevafree_nicescroll') == "on" ) :
				
			$classes[] = 'nicescroll';
	
		endif;
		
		if ( suevafree_setting('suevafree_disable_box_shadow') == "on" ) :
				
			$classes[] = 'disable_box_shadow';
	
		endif;
		
		return $classes;
	
	}
	
	add_filter('body_class', 'suevafree_body_classes_function');

}

/*-----------------------------------------------------------------------------------*/
/* POST CLASSES */
/*-----------------------------------------------------------------------------------*/   

if (!function_exists('suevafree_post_class')) {

	function suevafree_post_class($classes) {	

		$masonry  = 'post-container masonry-item col-md-4';
		$standard = 'post-container col-md-12';

		if ( !suevafree_is_single() ) {

			if ( is_home() ) {
				
				if ( !suevafree_setting('suevafree_home') || suevafree_setting('suevafree_home') == "masonry" ) {
	
					$classes[] = $masonry;
	
				} else {
	
					$classes[] = $standard;
	
				}
				
			} else if ( is_archive() ) {
	
				if ( !suevafree_setting('suevafree_category_layout') || suevafree_setting('suevafree_category_layout') == "masonry" ) {
	
					$classes[] = $masonry;
	
				} else {
	
					$classes[] = $standard;
	
				}
				
			} else if ( is_search() ) {
				
				if ( !suevafree_setting('suevafree_search_layout') || suevafree_setting('suevafree_search_layout') == "masonry" ) {
	
					$classes[] = $masonry;
	
				} else {
	
					$classes[] = $standard;
	
				}
			
			}

		} else if ( suevafree_is_single() && suevafree_is_woocommerce_active('is_cart') ) {
		
			$classes[] = 'post-container col-md-12 woocommerce_cart_page';

		} else if ( suevafree_is_single() && !suevafree_is_woocommerce_active('is_product') ) {

			$classes[] = 'post-container col-md-12';

		} else if ( is_page() ) {

			$classes[] = 'full';

		}

		return $classes;
		
	}
	
	add_filter('post_class', 'suevafree_post_class');

}

/*-----------------------------------------------------------------------------------*/
/* Content template */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_template')) {

	function suevafree_template($id) {
	
		$template = array ( 
		
			"full" => "col-md-12" , 
			"left-sidebar" => "col-md-8" , 
			"right-sidebar" => "col-md-8"
		
		);
	
		$span = $template["right-sidebar"];
		$sidebar =  "right-sidebar";

		if ( suevafree_is_woocommerce_active('is_woocommerce') && ( suevafree_is_woocommerce_active('is_product_category') || suevafree_is_woocommerce_active('is_product_tag') ) && suevafree_setting('suevafree_woocommerce_category_layout') ) {
		
			$span = $template[suevafree_setting('suevafree_woocommerce_category_layout')];
			$sidebar =  suevafree_setting('suevafree_woocommerce_category_layout');

		} else if ( suevafree_is_woocommerce_active('is_woocommerce') && is_search() && suevafree_postmeta('suevafree_template') ) {
					
			$span = $template[esc_attr(suevafree_postmeta('suevafree_template'))];
			$sidebar =  esc_attr(suevafree_postmeta('suevafree_template'));
	
		} else if ( ( is_single() || suevafree_is_woocommerce_active('is_shop') ) && suevafree_postmeta('suevafree_template') ) {
					
			$span = $template[esc_attr(suevafree_postmeta('suevafree_template'))];
			$sidebar =  esc_attr(suevafree_postmeta('suevafree_template'));

		} else if ( ! suevafree_is_woocommerce_active('is_woocommerce') && ( is_category() || is_tag() || is_month() ) && suevafree_setting('suevafree_category_layout') ) {

			$span = $template[esc_attr(suevafree_setting('suevafree_category_layout'))];
			$sidebar =  esc_attr(suevafree_setting('suevafree_category_layout'));
						
		} else if ( is_home() && suevafree_setting('suevafree_home') ) {
					
			$span = $template[esc_attr(suevafree_setting('suevafree_home'))];
			$sidebar =  esc_attr(suevafree_setting('suevafree_home'));

		} else if ( ! suevafree_is_woocommerce_active('is_woocommerce') && is_search() && suevafree_setting('suevafree_search_layout') ) {

			$span = $template[esc_attr(suevafree_setting('suevafree_search_layout'))];
			$sidebar =  esc_attr(suevafree_setting('suevafree_search_layout'));
						
		}

		return ${$id};
		
	}

}

/*-----------------------------------------------------------------------------------*/
/* SIDEBAR */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_sidebar_list')) {

	function suevafree_sidebar_list( $sidebar_type) {
	
		$suevafree_sidebars = get_option(suevafree_themename());

		if ( $sidebar_type == "side" || $sidebar_type == "onepage" ) :

			$default = array( $sidebar_type."-sidebar-area" => "Default" );

		else:

			$default = array("none" => "None", $sidebar_type."-sidebar-area" => "Default");

		endif;
		
		return $default;
		
	}

}

/*-----------------------------------------------------------------------------------*/
/* GET PAGED */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_paged')) {

	function suevafree_paged() {
		
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		
		return $paged;
		
	}

}

/*-----------------------------------------------------------------------------------*/
/* Prettyphoto at post gallery */
/*-----------------------------------------------------------------------------------*/   

if (!function_exists('suevafree_prettyPhoto')) {

	function suevafree_prettyPhoto( $html, $id, $size, $permalink, $icon, $text ) {
		
		if ( ! $permalink )
			return str_replace( '<a', '<a data-rel="prettyPhoto" ', $html );
		else
			return $html;
	}

	add_filter( 'wp_get_attachment_link', 'suevafree_prettyPhoto', 10, 6);

}

/*-----------------------------------------------------------------------------------*/
/* Excerpt more */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('suevafree_hide_excerpt_more')) {

	function suevafree_hide_excerpt_more() {
		return '';
	}

	add_filter('the_content_more_link', 'suevafree_hide_excerpt_more');
	add_filter('excerpt_more', 'suevafree_hide_excerpt_more');

}

/*-----------------------------------------------------------------------------------*/
/* Customize excerpt more */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('suevafree_customize_excerpt_more')) {

	function suevafree_customize_excerpt_more( $excerpt ) {
	
		global $post;

		if ( suevafree_is_single() ) :

			return $excerpt;

		else:

			$allowed = array(
				'span' => array(
					'class' => array(),
				),
			);
	
			$class = 'button ' . suevafree_setting('suevafree_readmore_layout');
			$button = esc_html__('saiba mais','suevafree');
			$container = 'class="read-more"';
	
			if ( suevafree_setting('suevafree_readmore_layout') == "default" || !suevafree_setting('suevafree_readmore_layout') ) : 
			
				$class = 'button default';
				$button = esc_html__('saiba mais','suevafree');
				$container = 'class="read-more"';
	
			else :
	
				$class = 'nobutton';
				$button = ' [&hellip;] ';
				$container = '';
	
			endif;
		
			if ( $pos=strpos($post->post_content, '<!--more-->') && !has_excerpt( $post->ID )): 
			
				$content = substr(apply_filters( 'the_content', get_the_content()), 0, -5);
			
			else:
			
				$content = $excerpt." [...]";
	
			endif;
	
			return $content. '<a '. wp_kses($container, $allowed) . ' href="' . esc_url(get_permalink($post->ID)) . '" title="'.esc_html__('Read More','suevafree').'"> <span class="'.esc_attr($class).'">'.$button.'</span></a>';

		endif;
		

	}
	
	add_filter( 'get_the_excerpt', 'suevafree_customize_excerpt_more' );

}

/*-----------------------------------------------------------------------------------*/
/* Remove category list rel */
/*-----------------------------------------------------------------------------------*/   

if (!function_exists('suevafree_remove_category_list_rel')) {

	function suevafree_remove_category_list_rel($output) {
		$output = str_replace('rel="category"', '', $output);
		return $output;
	}

	add_filter('wp_list_categories', 'suevafree_remove_category_list_rel');
	add_filter('the_category', 'suevafree_remove_category_list_rel');

}

/*-----------------------------------------------------------------------------------*/
/* Remove thumbnail dimensions */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_remove_thumbnail_dimensions')) {

	function suevafree_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	
	}

	add_filter( 'post_thumbnail_html', 'suevafree_remove_thumbnail_dimensions', 10, 3 );

}
  
/*-----------------------------------------------------------------------------------*/
/* Remove css gallery */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_my_gallery_style')) {

	function suevafree_my_gallery_style() {
		return "<div class='gallery'>";
	}

	add_filter( 'gallery_style', 'suevafree_my_gallery_style', 99 );

}

/*-----------------------------------------------------------------------------------*/
/* POST ICON */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_posticon')) {

	function suevafree_posticon() {
	
		$icons = array ( 
			"video" => "fa fa-play" , 
			"gallery" => "fa fa-camera" , 
			"audio" => "fa fa-volume-up" , 
			"chat" => "fa fa-users", 
			"status" => "fa fa-keyboard-o", 
			"image" => "fa fa-picture-o" ,
			"quote" => "fa fa-quote-left", 
			"link" => "fa fa-external-link", 
			"aside" => "fa fa-file-text-o", 
		);
	
		if ( get_post_format() ) { 
		
			$icon = '<span class="post-icon"><i class="'.$icons[get_post_format()].'"></i><span>' . ucfirst( strtolower( get_post_format() )) . '</span></span>'; 
		
		} else {
		
			$icon = '<span class="post-icon"><i class="fa fa-pencil-square-o"></i><span>' . esc_html__( "Article","suevafree") . '</span></span>'; 
		
		}

		return $icon;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* THUMBNAIL WIDTH */
/*-----------------------------------------------------------------------------------*/         

if (!function_exists('suevafree_get_width')) {

	function suevafree_get_width() {
		
		if (suevafree_setting('suevafree_screen3')):
		
			return esc_attr(suevafree_setting('suevafree_screen3'));
		
		else:
		
			return "1170";
		
		endif;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* THUMBNAIL HEIGHT */
/*-----------------------------------------------------------------------------------*/         

if (!function_exists('suevafree_get_thumbs')) {

	function suevafree_get_thumbs($type) {
		
		if (suevafree_setting('suevafree_'.$type.'_thumbinal')):
		
			return esc_attr(suevafree_setting('suevafree_'.$type.'_thumbinal'));
		
		else:
		
			return "600";
		
		endif;
	
	}

}

/*-----------------------------------------------------------------------------------*/
/* WIDGETS WITHOUT PADDING */
/*-----------------------------------------------------------------------------------*/   

if (!function_exists('suevafree_widget_class')) {

	function suevafree_widget_class( $params ) {
		
		$name = $params[0]['widget_name'];
		$id = $params[0]['id'];

		/*-----------------------------------------------------------------------------------*/
		/* SIDE SIDEBAR AREA */
		/*-----------------------------------------------------------------------------------*/   

		if ( in_array( $id, array("side-sidebar-area", "home-sidebar-area", "category-sidebar-area", "search-sidebar-area")) && suevafree_setting('suevafree_sidebar_layout') == "sneak" )
			$params[0]['before_widget'] = preg_replace( '/class="widget-box/', 'class="post-article', $params[0]['before_widget'], 1 );

		/*-----------------------------------------------------------------------------------*/
		/* NO PADDING */
		/*-----------------------------------------------------------------------------------*/   

		$check = array(
		
			"Instagram Slider",
			"SuevaFree Call To Action",
			"SuevaFree Team Slideshow",
			"SuevaFree Testimonial Slideshow",
			"SuevaFree News Slideshow",
			"SuevaFree Services Widget",
			"SuevaFree Contact Form Widget",
			"SuevaFree Counter Widget"
			
		);

		if ( in_array( $name, $check ) )
			$params[0]['before_widget'] = preg_replace( '/class="post-article/', 'class="no-padding', $params[0]['before_widget'], 1 );

		return $params;
		
	}

	add_filter( 'dynamic_sidebar_params', 'suevafree_widget_class' );

}

/*-----------------------------------------------------------------------------------*/ 
/* STYLES AND SCRIPTS */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_scripts_styles')) {

	function suevafree_scripts_styles() {
	
		wp_enqueue_style( 'suevafree_style', get_stylesheet_uri(), array() );

		suevafree_enqueue_style('/assets/css');

		$fonts_args = array(
			'family' =>	str_replace('|', '%7C','Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Raleway:400,800,900,700,600,500,300,200,100|Allura'),
			'subset' =>	'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic'
		);
		
		wp_enqueue_style( 'suevafree_google_fonts', add_query_arg ( $fonts_args, "https://fonts.googleapis.com/css" ), array(), null );

		$header_layout = suevafree_setting( 'suevafree_header_layout', 'header_layout_1');
		wp_enqueue_style( 'suevafree-' . $header_layout , get_template_directory_uri() . '/assets/css/header/' . $header_layout . '.css' ); 

		if ( get_theme_mod('suevafree_skin') ) 
			wp_enqueue_style( 'suevafree-' . get_theme_mod('suevafree_skin') , get_template_directory_uri() . '/assets/skins/' . get_theme_mod('suevafree_skin') . '.css' ); 
		
		wp_enqueue_script( "jquery-ui-core", array('jquery'));
		wp_enqueue_script( "jquery-ui-tabs", array('jquery'));
		wp_enqueue_script( "masonry", array('jquery') );

		suevafree_enqueue_script('/assets/js');
	
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		
		wp_enqueue_script('jquery');
		 
		wp_enqueue_script ( 'suevafree-html5', get_template_directory_uri().'/assets/scripts/html5.js');
		wp_script_add_data ( 'suevafree-html5', 'conditional', 'IE 8' );
		
		wp_enqueue_script ( 'suevafree-selectivizr', get_template_directory_uri().'/assets/scripts/selectivizr-min.js');
		wp_script_add_data ( 'suevafree-selectivizr', 'conditional', 'IE 8' );

	}

	add_action( 'wp_enqueue_scripts', 'suevafree_scripts_styles' );

}

/*-----------------------------------------------------------------------------------*/
/* THEME SETUP */
/*-----------------------------------------------------------------------------------*/   

if (!function_exists('suevafree_setup')) {

	function suevafree_setup() {
		
		global $content_width;

		if ( ! isset( $content_width ) )
			$content_width = suevafree_get_width();
		
		load_theme_textdomain( 'suevafree', get_template_directory() . '/languages');
	
		add_filter('widget_text', 'do_shortcode');

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'custom-background', array(
			'default-color' => 'f3f3f3',
		) );

		add_theme_support( 'custom-header', array( 
			'default-image' => get_template_directory_uri() . '/assets/images/background/header.jpg'
		) );

		add_theme_support( 'post-formats', 
			
			array( 
				'aside',
				'gallery',
				'quote',
				'video',
				'audio',
				'link',
				'status',
				'chat',
				'image'
			)
		
		);
		
		add_image_size( 'suevafree_blog_thumbnail', suevafree_get_width(), suevafree_get_thumbs('blog'), TRUE ); 
		add_image_size( 'suevafree_large', 449,304, TRUE ); 
		add_image_size( 'suevafree_medium', 290,220, TRUE ); 
		add_image_size( 'suevafree_small', 211,150, TRUE ); 

		register_nav_menu( 'main-menu', 'Main menu' );
		register_nav_menu( 'one-page-menu', 'One Page menu' );

		suevafree_require('/core/post-formats/');
		suevafree_require('/core/templates/header/');
		suevafree_require('/core/templates/content/');
		suevafree_require('/core/templates/sidebar/');
		suevafree_require('/core/templates/footer/');
		suevafree_require('/core/includes/');
		suevafree_require('/core/admin/customize/');
		suevafree_require('/core/functions/');
		suevafree_require('/core/metaboxes/');

	}

	add_action( 'after_setup_theme', 'suevafree_setup' );

}

?>