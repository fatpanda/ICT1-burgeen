<?php
/**
 * Campaign sidebar.
 *
 * @package funder
 * @since funder 1.5
 */

global $campaign, $wp_embed;
?>

<div id="sidebar" class="span4 sidebar_descr last">
    <div id="back_this_project_block">
        <div class="backers_days_blocks first">
            <div class="row-fluid">
                <div class="span1" style="margin-right: 10px"><div class="image_first"></div></div>
                <div class="text_backers_days_blocks span10">
                    <div class="top_text_backers_days_blocks"><?php echo $campaign->backers_count(); ?></div>
                    <div class="bottom_text_backers_days_blocks"><?php echo _nx( 'Backer', 'Backers', $campaign->backers_count(), 'number of backers for campaign', 'funder' ); ?></div>
                </div>
            </div>
        </div>
        <div class="backers_days_blocks">
            <div class="row-fluid">
                <div class="span1" style="margin-right: 10px"><div class="image_second"></div></div>
                <div class="text_backers_days_blocks span10">
                    <div class="top_text_backers_days_blocks"><?php echo $campaign->current_amount(); ?></div>
                    <div class="bottom_text_backers_days_blocks"><?php printf( __( 'Pledged of %s Goal', 'funder' ), $campaign->goal() ); ?></div>
                </div>
            </div>
        </div>
        <div class="backers_days_blocks">
                    <div class="row-fluid">
                        <div class="span1" style="margin-right: 10px"><div class="image_third"></div></div>
                            <div class="text_backers_days_blocks span10">
                                <?php if ( ! $campaign->is_endless() ) : ?>
                                <?php if ( $campaign->days_remaining() > 0 ) : ?>
                                      <div class="top_text_backers_days_blocks"><?php echo $campaign->days_remaining(); ?></div>
                                      <div class="bottom_text_backers_days_blocks"><?php echo _n( 'Day to Go', 'Days to Go', $campaign->days_remaining(), 'funder' ); ?></div>
                                <?php else : ?>
                                      <div class="top_text_backers_days_blocks"><?php echo $campaign->hours_remaining(); ?></h3>
                                      <div class="bottom_text_backers_days_blocks"><?php echo _n( 'Hour to Go', 'Hours to Go', $campaign->hours_remaining(), 'funder' ); ?></div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                     </div>
          
              <?php
                    if ( ! $campaign->is_endless() ) :
                        $end_date = date_i18n( get_option( 'date_format' ), strtotime( $campaign->end_date() ) );
                ?>
                
                <p class="fund">
                    <?php if ( 'fixed' == $campaign->type() ) : ?>
                    <?php printf( __( 'This %3$s will only be funded if at least %1$s is pledged by %2$s.', 'funder' ), $campaign->goal(), $end_date, strtolower( edd_get_label_singular() ) ); ?>
                    <?php elseif ( 'flexible' == $campaign->type() ) : ?>
                    <?php printf( __( 'All funds will be collected on %1$s.', 'funder' ), $end_date ); ?>
                    <?php else : ?>
                    <?php printf( __( 'All pledges will be collected automatically until %1$s.', 'funder' ), $end_date ); ?>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
              </div> 
              
              <?php if ( $campaign->is_active() ) : ?>
                <div class="back_this_project_button">
				<a href="#contribute-now" class="contribute btn btn-large back_project"><small><?php _e( 'BACK THIS PROJECT', 'funder' ); ?></small></a>
			  <?php else : ?>
			    <a class="btn-green expired"><?php printf( __( '%s Expired', 'funder' ), edd_get_label_singular() ); ?></a>
                </div>
			  <?php endif; ?>
                         
              <div id="pledges_block mt20">
                      <div class="single-reward-levels">
                 	<?php 
					 echo ' <h3 class="decoration text-center"><span class="nobacgr_desc">'.__('Pledges','funder').'</span></h3>';
					 
                      do_action( 'funder_contribute_modal_top', $campaign );
              
                      if ( $campaign->is_active() ) :
                          echo edd_get_purchase_link( array( 
                              'download_id' => $campaign->ID,
                              'class'       => '',
                              'price'       => false
                          ) ); 
					 
                      else : // Inactive, just show options with no button
                          atcf_campaign_contribute_options( edd_get_variable_prices( $campaign->ID ), 'checkbox', $campaign->ID );
                      endif;
                      do_action( 'funder_contribute_modal_bottom', $campaign ); 
                     ?>
                    </div>
              </div>
       </div>   
</div>  			