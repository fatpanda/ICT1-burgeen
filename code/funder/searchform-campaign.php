<?php
/**
 * The template for displaying search forms in funder
 *
 * @package funder
 * @since funder 1.0
 */
?>

   
            <div class="search_top search">
               <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                <div class="wpg-search" id="searchh">
                    <span class="white"><strong><?php _e('Find a project:','funder')?></strong></span>
                   	<input class="span7 search-query ui-autocomplete-input" type="text" name="s" placeholder="" value="<?php the_search_query(); ?>"/>
                     <button type="submit" class="submit" name="submit" id="searchsubmit"><?php _e('Search','funder')?></button>
		            	<input type="hidden" name="type" value="download" />
                </div>
              </form>
            </div>
            
         