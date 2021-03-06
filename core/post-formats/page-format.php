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

if (!function_exists('suevafree_page_format_function')) {

	function suevafree_page_format_function() {

		do_action('suevafree_thumbnail', 
			
			array(	'id' =>'suevafree_blog_thumbnail', 
					'type' =>'default', 
					'icon' => esc_attr(suevafree_setting( 'suevafree_display_icon', 'off' )) 
			) 
			
		); 
	
	?>
		
        <div class="post-article page-details-<?php echo str_replace('suevafree_before_content_', '', suevafree_setting('suevafree_page_details_layout', 'suevafree_before_content_4')); ?>">
        
            <?php 
				
				do_action( suevafree_setting('suevafree_page_details_layout', 'suevafree_before_content_4') );
                do_action('suevafree_after_content'); 
                
            ?>
        
        </div>

	<?php

	}

	add_action( 'suevafree_page_format', 'suevafree_page_format_function', 10, 2 );

}

?>