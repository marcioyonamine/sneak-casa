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

if (!function_exists('suevafree_image_format_function')) {

	function suevafree_image_format_function() {

		if ( ! suevafree_is_single() ) :
		
			do_action('suevafree_thumbnail', 
				
				array(	'id' =>'suevafree_blog_thumbnail', 
						'type' =>'overlay', 
						'icon' => esc_attr(suevafree_setting( 'suevafree_display_icon','off' )) 
				) 
				
			); 

		else :

			do_action('suevafree_thumbnail', 
				
				array(	'id' =>'suevafree_blog_thumbnail', 
						'type' =>'default', 
						'icon' => esc_attr(suevafree_setting( 'suevafree_display_icon','off' )) 
				) 
				
			); 

	?>
    
        <div class="post-article post-details-<?php echo str_replace('suevafree_before_content_', '', suevafree_setting('suevafree_post_details_layout')); ?>">
        
            <?php 
				
				do_action( suevafree_setting('suevafree_post_details_layout', 'suevafree_before_content_1') );
                do_action('suevafree_after_content'); 
                
            ?>
        
        </div>
    
	<?php 
		
		endif; 


	}

	add_action( 'suevafree_image_format', 'suevafree_image_format_function', 10, 2 );

}

?>