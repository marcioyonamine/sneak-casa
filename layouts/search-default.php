<div class="container">

	<div class="row">
    
	<?php if ( ( suevafree_template('sidebar') == "left-sidebar" ) || ( suevafree_template('sidebar') == "right-sidebar" ) ) : ?>
        
        <div class="<?php echo suevafree_template('span') .' '. suevafree_template('sidebar'); ?>">

    		<?php do_action('suevafree_searched_item'); ?> 

            <div class="row"> 
        
    <?php 
		
		else:

		do_action('suevafree_searched_item', 'off');

		endif;
		
		if ( have_posts() ) : while ( have_posts() ) : the_post(); 

	?>

		<div <?php post_class(); ?> >
    
			<?php do_action('suevafree_postformat'); ?>
            <div class="clear"></div>
            
		</div>
		
	<?php 
	
		endwhile; 
		else:  
	
	?>

		<div class="post-container col-md-12" >
    
			<article class="post-article">
                    
				<h1><?php esc_html_e( 'Not found.',"suevafree" ) ?></h1>
				<h1><?php esc_html_e( 'Sorry, no posts matched your criteria',"suevafree" ) ?> <strong>: <?php echo esc_attr($s); ?> </strong></h1>
     
			</article>
    
		</div>
	
	<?php 
		
		endif;
		if ( ( suevafree_template('sidebar') == "left-sidebar" ) || ( suevafree_template('sidebar') == "right-sidebar" ) ) : 
			
	?>
        
            </div>
        
        </div>
        
    <?php 
	
		endif;

		if ( suevafree_template('span') == "col-md-8" ) :
			
			do_action('suevafree_side_sidebar', 'search-sidebar-area');			
			
		endif; 
	
	?>
           
    </div>
    
    <?php do_action( 'suevafree_pagination', 'archive'); ?>
    
</div>