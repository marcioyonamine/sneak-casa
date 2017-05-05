<?php

/**
 * Wp in Progress
 * 
 * @package Wordpress
 * @author WPinProgress
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * It is also available at this URL: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/*-----------------------------------------------------------------------------------*/
/* Socials */
/*-----------------------------------------------------------------------------------*/ 

if (!function_exists('suevafree_socials_function')) {

	function suevafree_socials_function() {

		$allowed = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'class' => array(),
				'target' => array()
			),
			'i' => array(
				'class' => array(),
			)
		);

		$socials = array ( 
			
			"facebook" => array( "icon" => "fa fa-facebook" , "target" => "_blank" ),
			"twitter" => array( "icon" => "fa fa-twitter" , "target" => "_blank" ),
			"flickr" => array( "icon" => "fa fa-flickr" , "target" => "_blank" ),
			"google" => array( "icon" => "fa fa-google-plus" , "target" => "_blank" ),
			"linkedin" => array( "icon" => "fa fa-linkedin" , "target" => "_blank" ),
			"pinterest" => array( "icon" => "fa fa-pinterest" , "target" => "_blank" ),
			"tumblr" => array( "icon" => "fa fa-tumblr" , "target" => "_blank" ),
			"youtube" => array( "icon" => "fa fa-youtube" , "target" => "_blank" ),
			"skype" => array( "icon" => "fa fa-skype" , "target" => "_self" ),
			"instagram" => array( "icon" => "fa fa-instagram" , "target" => "_blank" ),
			"deviantart" => array( "icon" => "fa fa-deviantart" , "target" => "_blank" ),
			"github" => array( "icon" => "fa fa-github" , "target" => "_blank" ),
			"xing" => array( "icon" => "fa fa-xing" , "target" => "_blank" ),
			"whatsapp" => array( "icon" => "fa fa-whatsapp" , "target" => "_self" ),
			"email" => array( "icon" => "fa fa-envelope" , "target" => "_self" ),
		
		);

		$i = 0;
		$html = "";
		
		foreach ( $socials as $name => $attrs) { 
		
			if ( suevafree_setting('suevafree_footer_'.$name.'_button') ): 

				$i++;	
				$html.= '<a href="'.esc_url(suevafree_setting('suevafree_footer_'.$name.'_button'), array( 'http', 'https', 'tel', 'skype', 'mailto' ) ).'" target="'.$attrs['target'].'" title="'.$name.'" class="social"> <i class="'.$attrs['icon'].'" ></i> </a> ';
			
			endif;
			
		}
		
		if ( suevafree_setting('suevafree_footer_rss_button') == "on" ): 
		
			$i++;	
			$html.= '<a href="'. esc_url(get_bloginfo('rss2_url')). '" title="Rss" class="social rss"> <i class="fa fa-rss" ></i>  </a> ';
		
		endif; 
			
		if ( $i > 0 ) {
			
			echo wp_kses($html, $allowed);
	
		}
		
	}
	
	add_action( 'suevafree_socials', 'suevafree_socials_function', 10, 2 );

}

?>