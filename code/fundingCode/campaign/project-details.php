<?php
/**
 * Campaign details.
 *
 * @package funder
 * @since funder 1.5
 */

global $campaign, $wp_embed;
?>

<article class="project-details">
	<div class="image">
		<?php if ( $campaign->video() ) : ?>
			<div class="video-container">
				<?php echo $wp_embed->run_shortcode( '[embed]' . $campaign->video() . '[/embed]' ); ?>
			</div>
		<?php else : ?>
			<?php the_post_thumbnail( 'blog' ); ?>
		<?php endif; ?>
	</div>
	<div class="right-side">
		<ul class="campaign-stats">
			<li class="progress">
				<h3><?php echo $campaign->current_amount(); ?></h3>
				<p><?php printf( __( 'Pledged of %s Goal', 'funder' ), $campaign->goal() ); ?></p>

				<div class="bar"><span style="width: <?php echo $campaign->percent_completed(); ?>"></span></div>
			</li>

			<li class="backer-count">
				<h3><?php echo $campaign->backers_count(); ?></h3>
				<p><?php echo _nx( 'Backer', 'Backers', $campaign->backers_count(), 'number of backers for campaign', 'funder' ); ?></p>
			</li>
			<?php if ( ! $campaign->is_endless() ) : ?>
			<li class="days-remaining">
				<?php if ( $campaign->days_remaining() > 0 ) : ?>
					<h3><?php echo $campaign->days_remaining(); ?></h3>
					<p><?php echo _n( 'Day to Go', 'Days to Go', $campaign->days_remaining(), 'funder' ); ?></p>
				<?php else : ?>
					<h3><?php echo $campaign->hours_remaining(); ?></h3>
					<p><?php echo _n( 'Hour to Go', 'Hours to Go', $campaign->hours_remaining(), 'funder' ); ?></p>
				<?php endif; ?>
			</li>
			<?php endif; ?>
		</ul>

		<div class="contribute-now">
			<?php if ( $campaign->is_active() ) : ?>
				<a href="#contribute-now" class="btn-green contribute"><?php _e( 'Contribute Now', 'funder' ); ?></a>
			<?php else : ?>
				<a class="btn-green expired"><?php printf( __( '%s Expired', 'funder' ), edd_get_label_singular() ); ?></a>
			<?php endif; ?>
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
</article>