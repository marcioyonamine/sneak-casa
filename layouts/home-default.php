<div class="container">
	
    <div class="row" id="blog" >
    
	<?php if ( ( suevafree_template('sidebar') == "left-sidebar" ) || ( suevafree_template('sidebar') == "right-sidebar" ) ) : ?>
        
        <div class="<?php echo suevafree_template('span') .' '. suevafree_template('sidebar'); ?>"> 
        
        	<div class="row"> 
        
    <?php endif; ?>
        

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <div <?php post_class(); ?> >
    
				<?php do_action('suevafree_postformat'); ?>
                <div class="clear"></div>
            
            </div>
		
		<?php endwhile; else:  ?>

		<div class="post-container col-md-12" >
    
                <article class="post-article category">
                    
                    <h1><?php esc_html_e( 'Not found',"suevafree" ) ?></h1>
                    <p><?php esc_html_e( 'Sorry, no posts matched into ',"suevafree" ) ?> <strong>: <?php the_category(' '); ?></strong></p>
     
                </article>
    
            </div>
	
		<?php endif; ?>
        
	<?php if ( ( suevafree_template('sidebar') == "left-sidebar" ) || ( suevafree_template('sidebar') == "right-sidebar" ) ) : ?>
        
        	</div>
            
        </div>
        
    <?php 
	
		endif;

		if ( suevafree_template('span') == "col-md-8" ) :
			
			do_action( 'suevafree_side_sidebar', 'home-sidebar-area');
			
		endif; 
		
	?>
           
    </div>

	<?php do_action( 'suevafree_pagination', 'home'); ?>

</div>