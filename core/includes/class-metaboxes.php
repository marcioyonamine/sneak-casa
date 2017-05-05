<?php

/**
 * This file belongs to the TIP Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( !class_exists( 'suevafree_metaboxes' ) ) {

	class suevafree_metaboxes {
	   
		public $posttype;
		public $metaboxes_fields;
	   
		public function __construct( $posttype, $fields = array() ) {
	
			$this->posttype = $posttype;
			$this->metaboxes_fields = $fields;
			
			add_action( 'add_meta_boxes', array( &$this, 'new_metaboxes' ) ); 
			add_action( 'save_post', array( &$this, 'suevafree_metaboxes_save' ) );
		}
	
		public function new_metaboxes() {
	
			$posttype = $this->posttype ;
			add_meta_box( $posttype, ucfirst($posttype).' settings', array( &$this, 'metaboxes_panel' ), $posttype, 'normal', 'high' );
		
		}
		
		public function metaboxes_panel() {
	
			$metaboxes_fields = $this->metaboxes_fields ;
	
			global $post, $post_id;
			
			foreach ($metaboxes_fields as $value) {
			switch ( $value['type'] ) { 
		
			case 'navigation': ?>
			
				<div id="tabs" class="suevafree_metaboxes">
						
					<ul>
			
						<?php 
						
							foreach ($value['item'] as $option => $name ) { 
								echo "<li class='".$option."'><a href='#".str_replace(" ", "", $option)."'>".$name."</a></li>"; 
							} 
						?>
                        
                        <li class="clear"></li>
                        
					</ul>
					   
			<?php	
					
			break;
		
			case 'begintab': ?>

				<div id="<?php echo esc_attr($value['tab']);?>">
		
			<?php	
					
			break;
		
			case 'endtab': ?>
			
				</div>
		
			<?php	
					
			break;
			
			}
			
			foreach ($value as $field) {
		
			if (isset($field['type'])) : 
		
				switch ( $field['type'] ) { 
		
					case 'start':  ?>
					<div class="postformat" id="<?php echo esc_attr($field['id']); ?>">
				
					<?php break;
					
					case 'end':  ?>
					</div>
					
					<?php break;
					
					case "on-off": ?>
				
					<div class="suevafree_inputbox">
		
						<div class="input-left">
		
							<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label>
							<p><?php echo esc_attr($field['desc']); ?></p>
                            
						</div>
						
                        <div class="input-right">
		
								<div class="bool-slider <?php if ( suevafree_postmeta($field['id']) != "") { echo stripslashes( suevafree_postmeta($field['id'])); } else { echo esc_attr($field['std']); } ?>">
									
									<div class="inset">
										<div class="control"></div>
									</div>
									
									<input name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" type="hidden" value="<?php if ( suevafree_postmeta( $field['id']) != "") { echo esc_attr(suevafree_postmeta( $field['id'])); } else { echo esc_attr($field['std']); } ?>" class="on-off" />
	
								</div>  
								
								<div class="clear"></div>      
						
						</div>	
							
						<div class="clear"></div>
						
					</div>
				
					<?php break;
		
					case 'title':  ?>
					
					<h2 class="title"><?php echo esc_attr($field['name']); ?></h2>
					
					<?php break;
		
					case 'text':  ?>
					
					<div class="suevafree_inputbox">
						
						<div class="input-left">
						
							<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label><br />
							<em> <?php echo esc_attr($field['desc']); ?> </em>
							
						</div>
						
						<div class="input-right">
						
							<input name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php if ( suevafree_postmeta( $field['id']) != "") { echo esc_html(suevafree_postmeta( $field['id'])); } ?>" />
							
						</div>
						
						<div class="clear"></div>
					
                    </div>
				
					<?php break;
		
					case 'color':  ?>
					
					<div class="suevafree_inputbox">
						
						<div class="input-left">
						
							<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label><br />
							<em> <?php echo esc_attr($field['desc']); ?> </em>
							
						</div>
						
						<div class="input-right">
						
							<input name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" type="text" value="<?php if ( suevafree_postmeta($field['id']) != "") { echo esc_attr(suevafree_postmeta($field['id'])); } else { echo esc_attr($field['std']); } ?>" data-default-color="<?php if ( suevafree_postmeta($field['id']) != "") { echo esc_attr(suevafree_postmeta($field['id'])); } else { echo esc_attr($field['std']); } ?>" class="suevafree_color_picker" />

						</div>
						
						<div class="clear"></div>
					
                    </div>
				
					<?php break;
		
					case 'select':  ?>
					
					<div class="suevafree_inputbox">
						
						<div class="input-left">
						
							<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label>
							<em> <?php echo esc_attr($field['desc']); ?> </em>
							
						</div>
						
						<div class="input-right">
                        
							<select name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" >
								
								<?php foreach ($field['options'] as $option => $values) { ?>
								<option <?php if ( suevafree_postmeta($field['id']) == $option || ( !suevafree_postmeta($field['id']) && $field['std'] == $option )) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr($option); ?>"><?php echo esc_attr($values); ?></option><?php } ?>  
                                
							</select>
                            
                            <span></span>
						
						</div>
						
						<div class="clear"></div>
					
                    </div>
                    
					<?php break;
		
					case 'taxonomy-select':  
					
					$slideshows = get_terms("slideshows");
					foreach ($slideshows as $slideshow)	
						{
							$wp_terms[$slideshow->term_id] = $slideshow->name;
						}
					?>
					
					<div class="suevafree_inputbox">
					
                    	<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label>
                        
						<select name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" >
						
                        	<option value="all"> All </option>
							<?php foreach ( $wp_terms as $option => $values) { ?>
                            <option <?php if (suevafree_postmeta( $field['id']) == $option) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr($option); ?>"><?php echo esc_attr($values); ?></option><?php } ?>
						
                        </select>
						
                        <em> <?php echo esc_attr($field['desc']); ?> </em>
					
                    </div>
				
				
					<?php break;
		
					case 'textarea':  ?>
							
					<div class="suevafree_inputbox">
						
						<div class="input-left">
						
                        	<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label><br />
							<em> <?php echo esc_attr($field['desc']); ?> </em>
						
                        </div>
						
                        <div class="input-right">
                        
                            <textarea name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" type="<?php echo esc_attr($field['type']); ?>" ><?php if ( suevafree_postmeta( $field['id']) != "") { echo stripslashes(suevafree_postmeta( $field['id'])); } ?></textarea>
						
                        </div>
						
                        <div class="clear"></div>
					
                    </div>
							
					<?php break;

					case 'revsliders':  ?>
					
					<div id="suevafree_revolution_slider" class="suevafree_inputbox slider <?php echo esc_attr($field['type']); ?>">
						
						<div class="input-left">
						
							<label for="<?php echo esc_attr($field['id']); ?>"><?php echo esc_attr($field['name']); ?></label><br />
							<em> <?php echo esc_attr($field['desc']); ?> </em>
							
						</div>
						
						<div class="input-right">
							
                            <select name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" >
                            	
                                <option value="none">None</option>
                                
								<?php foreach ( suevafree_get_revsliders() as $alias => $title ) { ?>
                                    <option <?php if (suevafree_postmeta( $field['id']) == $alias ) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr($alias); ?>"><?php echo esc_attr($title); ?></option>
								<?php } ?>
                                
							</select>
						
						</div>
						
						<div class="clear"></div>
                        
					</div>
				
					<?php break;

					case 'defaultslider':

					?>

						<div id="theme_sliders">
                        	
                            <ul class="orders">
                    
					<?php	

						$suevafree_gallery = suevafree_postmeta('galleries');
						
						$i = 0;

						if ( $suevafree_gallery ) { 

						foreach ( $suevafree_gallery as $slide => $input) { 
							
							$i++;
							
					?>
							<li class="suevafree_container <?php echo esc_attr($slide); ?>">
								
								<h5 class="element"><?php if ($input['title']) { echo esc_html($input['title']); } else { esc_attr_e('Untitle slide', 'suevafree'); } ?></h5>
								
                                <div class="suevafree_mainbox"> 
												
								<?php 
                                    
                                    foreach ( $input as $gallery => $element ) {
                                        
                                    if( $gallery == "title") { 
                                
                                ?>
                                            
                                        <div class="suevafree_inputbox">
                                                
                                            <div class="input-left">
                                                        
                                                <label for="suevafree_skins"><?php echo esc_html($gallery); ?></label>
                                                        
                                            </div>
                                                    
                                            <div class="input-right">
                                                    
                                                <input type="text" name="galleries[<?php echo esc_html($slide); ?>][<?php echo esc_html($gallery); ?>]" value="<?php echo esc_html($element); ?>">
                                                    
                                            </div>
                                        
                                            <div class="clear"></div>
                                                    
                                        </div>
                                                                
                                <?php } else if( $gallery == "url") { ?>
            
                                        <div class="suevafree_inputbox">
                                                    
                                            <div class="input-left">
                                                        
                                                <label for="suevafree_skins"><?php esc_attr_e('Image URL', 'suevafree'); ?></label>
                                                        
                                            </div>
                                                    
                                            <div class="input-right">
                                                    
                                                <input type="text" id="suevafree_<?php echo esc_html($slide); ?>"name="galleries[<?php echo esc_html($slide); ?>][url]" class="upload_attachment" value="<?php echo esc_url($element); ?>"/>
                                                <input type="button" name="upload_button" class="button upload_button" value="<?php esc_attr_e('Upload', 'suevafree'); ?>" />
                                                    
                                            </div>
                                                    
                                            <div class="clear"></div>
                                                    
                                        </div>
                                
                                        <div class="suevafree_inputbox">
                                                    
                                            <div class="input-left">
                                                        
                                                <label for="suevafree_skins"><?php esc_attr_e('Image Preview', 'suevafree'); ?></label>
                                                        
                                            </div>
                                                    
                                            <div class="input-right">
                                                    
                                                <img class="image-preview" src="<?php echo esc_url($element); ?>" alt="<?php esc_attr_e('Image Preview', 'suevafree'); ?>"> 
                                                    
                                            </div>
                                                    
                                            <div class="clear"></div>
                                                    
                                        </div>
                                
                                <?php 
                                            
                                        } 
                                            
                                    } 
                                            
                                ?>
                                                   
                                        <div class="suevafree_inputbox">
                                                    
                                            <a class="button delete" rel="<?php echo esc_html($slide); ?>"><?php esc_attr_e('Delete', 'suevafree'); ?></a>
                                            <div class="clear"></div>
                                                    
                                        </div>
                                            
									</div>	
                                    			
								</li>  
					
					<?php 
					
								}
							
							} 
						
					?>


							</ul>

							<input type="hidden" id="elements" value="<?php echo esc_attr($i); ?>">
							<p class="suevafree_input"><input type="button" class="button" id="add_gallery" value="+"></p>

                    	</div>

					<?php
						
						break;
				
					}
				
				endif;
				
				}
			
			}
	
		}
		
		public function suevafree_metaboxes_save() {
		
				global $post_id, $post;
				
				$metaboxes_fields = $this->metaboxes_fields ;
		
				foreach ( $metaboxes_fields as $value ) {
					
					foreach ($value as $field) {

						if ( isset($field['id']) && isset ($_POST[$field['id']] ) ) {

							$new = $_POST[$field['id']];

							if ( $field['id'] == "galleries" ) {	
							
							$suevafree_gallery = suevafree_postmeta('galleries');
						
							if ( $suevafree_gallery != false ) {
									
								$suevafree_gallery = maybe_unserialize( $suevafree_gallery );
								
							} else {
								
								$suevafree_gallery = array();
								
							}      
								
							$key = 0;
								
							foreach ( $new as $slide => $gallery) { 
		
								unset ($new[$slide]);
								$key++;
								$slideshow[ 'slide' . $key ] = array( 'title' => sanitize_text_field($gallery['title']), 'url' => esc_url($gallery['url']));
									
							}
						
							update_post_meta( $post_id , $field['id'] , $slideshow );
								
						} else if ( $field['id'] <> "galleries" ) {
		
							update_post_meta( $post_id , $field['id'], sanitize_text_field($new) );
		
						}
							
					}
						
				}
					
			}
				
		}
				
	}

}

?>