<?php get_header(); ?>

<div class="container content">

	<div class="row" >
    
        <div class="post-container col-md-12">
          
            <article class="post-article attachment">
            
				<?php while ( have_posts() ) : the_post(); ?>
    
                    <h1 class="title"> <a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a> </h1>
                    <span class="entry-date"><?php esc_html_e('On ','suevafree'); the_date();  esc_html_e(' by ','suevafree'); echo the_author_posts_link() ?></span>
    
                    <p> 
                    
                        <?php if (wp_attachment_is_image($post->id)) {  $att_image = wp_get_attachment_image_src( $post->id, "suevafree_blog_thumbnail");  ?>
                        
                            <a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>"><img src="<?php echo esc_url($att_image[0]);?>" width="<?php echo esc_html($att_image[1]);?>" height="<?php echo esc_html($att_image[2]);?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a>
                        
                        <?php } else { ?>
                        
                            <a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        
                        <?php } ?>
                    
                    </p>

				<?php endwhile; ?>

			</article>
                
            <div class="clear"></div>
            
        </div>

    </div>
    
</div>

<?php get_footer(); ?>