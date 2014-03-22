<?php
/**
 * @package techism
 */
?>
  
<li>
<?php if ( has_post_thumbnail() && the_post_thumbnail('techism-slider-image')) : ?>
        <?php the_post_thumbnail('techism-slider-image'); ?>
		;)
    <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/thumbnail.png" alt="Default Thumbnail" />
		:)
<?php endif; ?>
<div class="flex-caption">
	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?>
</div>
</li>