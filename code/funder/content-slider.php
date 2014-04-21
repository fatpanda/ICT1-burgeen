<?php
/**
 * @package funder
 * @since funder 1.0
 */

global $post;

$campaign = atcf_get_campaign( $post );

           $item_categories = get_the_terms( $post->ID, 'download_category' );
			$category_slug = " ";
			if( !empty($item_categories) ){
				foreach( $item_categories as $item_category ){
					$category_slug = $category_slug . $item_category->slug . ' ';
				}
			}
			
?>
 <div class="span4 bordered">
                        <div class="folder"><h4 class="text-center title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'funder' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
        <?php echo substr(get_the_title(),0,20); ?>
        </a></h4></div>
                        <div class="proj_name">
                            <div class="clear"></div>
                            <span class="fleft author"><?php echo $author = get_the_author(); ?></span>
                            <table class="icons">
                                <tbody>
                                <tr>
                                     <td class="icos_proj_sm bleft"><a class="group1" href="<?php echo $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" title=""><img src="<?php echo get_template_directory_uri(); ?>/img/icon_search.png" alt=""></a></td>
                                     <td class="icos_proj_sm bleft"><a href="<?php the_permalink(); ?>"><img alt="" src="<?php echo get_template_directory_uri(); ?>/img/icon_lock.png"></a></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="clear"></div>
                        </div>
                        <div class="folder border"> 
                        <div class="project-thumb">
						<?php
                
                               $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'catlog');
                                if ( !empty($large_image_url) ){
                                echo '<img src="'.$large_image_url [0].'" alt="image" />';
                                }else{ //if image not avalible
                                echo '<img src="' . get_template_directory_uri() . '/img/img-holder.png" alt="image" />';
                                }	
                        
                       ?>
                       </div>
                      </div>
                         <div class="folder lorem lines">
  						<div class="bar"><span class="pline"  style="width: <?php echo $campaign->percent_completed(); ?>"><span class="pcircle"><small><?php echo $campaign->percent_completed(); ?></small></span></span></div>
      </div>
                        <p class="descr"><?php echo substr(get_the_title(),0,20); ?></p>
                        <div class="folder price topbordered">
                            <div class="span4"> <strong class="green"><span class="project_value"><?php printf( __( '%s', 'funder' ), $campaign->current_amount() ); ?></span></strong>
                            <p><?php _e('pledged','funder')?></p>
                          </div>
                          <div class="span4 bleft"> <strong><?php echo $campaign->backers_count(); ?></strong>
                            <p><?php _e('backers','funder')?></p>
                          </div>
                          <div class="span4 bleft">
                            <?php if ( $campaign->days_remaining() > 0 && ! $campaign->is_endless() ) : ?>
                            <?php printf( __( '<strong>%s</strong> <p>Days to Go</p>', 'funder' ), $campaign->days_remaining() ); ?>
                            <?php else : ?>
                            <?php printf( __( '<strong>%s</strong> <p>Hours to Go</p>', 'funder' ), $campaign->hours_remaining() ); ?>
                            <?php endif; ?>
                          </div>
                        </div>
                    </div>
                     
                    
   