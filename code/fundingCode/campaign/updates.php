<?php
/**
 * Campaign updates.
 *
 * @package funder
 * @since funder 1.0
 */

global $campaign;
?>

       <div id="updates_content">
            <div class="row-fluid">
                <div class="span12">
                    <?php if ( '' != $campaign->updates() ) : ?>
                        <div class="updates_block_text">
                            <p><?php echo $campaign->updates(); ?></p>
                        </div>
                     <?php else: ?>
                      <div class="updates_block_text">
                       <?php _e( 'No update yet', 'funder' ); ?>
                      </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
