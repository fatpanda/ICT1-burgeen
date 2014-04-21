<?php
/**
 * Campaign meta.
 *
 * @package funder
 * @since funder 1.5
 */

global $campaign;

$end_date = date_i18n( get_option( 'date_format' ), strtotime( $campaign->end_date() ) )
?>

<div class="post-meta campaign-meta">
	<?php do_action( 'funder_campaign_meta_before' ); ?>

	<div class="date">
		<i class="icon-calendar"></i>
		<?php printf( __( 'Launched: %s', 'funder' ), get_the_date() ); ?>
	</div>

	<?php if ( ! $campaign->is_endless() ) : ?>
	<div class="funding-ends">
		<i class="icon-clock"></i>
		<?php printf( __( 'Funding Ends: %s', 'funder' ), $end_date ); ?>
	</div>
	<?php endif; ?>

	<?php if ( $campaign->location() ) : ?>
	<div class="location">
		<i class="icon-compass"></i>
		<?php echo $campaign->location(); ?>
	</div>
	<?php endif; ?>

	<?php do_action( 'funder_campaign_meta_after' ); ?>
</div>