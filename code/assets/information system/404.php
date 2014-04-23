<?php get_header(); ?>
	<div class="content">
			
		<div class="post-listing post error404">
			<div class="post-inner">
				<h2 class="post-title"><?php _e( 'Not Found', 'tie' ); ?></h2>
				<div class="clear"></div>
				<div class="entry">
					<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'tie' ); ?></p>

					<div id="sitemap">
						<div class="sitemap-col">
							<h2><?php _e('Pages','tie'); ?></h2>
							<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->
							
						<div class="sitemap-col">
							<h2><?php _e('Categories','tie'); ?></h2>
							<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
						</div> <!-- end .sitemap-col -->
							
						<div class="sitemap-col">
							<h2><?php _e('Tags','tie'); ?></h2>
							<ul id="sitemap-tags">
								<?php $tags = get_tags();
								if ($tags) {
									foreach ($tags as $tag) {
										echo '<li><a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></li> ';
									}
								} ?>
							</ul>
						</div> <!-- end .sitemap-col -->
														
						<div class="sitemap-col<?php echo ' last'; ?>">
							<h2><?php _e('Authors','tie'); ?></h2>
							<ul id="sitemap-authors" ><?php wp_list_authors('optioncount=1&exclude_admin=0'); ?></ul>
						</div> <!-- end .sitemap-col -->
					
					</div> <!-- end #sitemap -->
						
				</div><!-- .entry /-->	
			
			</div><!-- .post-inner -->
		</div><!-- .post-listing -->
	</div>
<?php get_footer(); ?>