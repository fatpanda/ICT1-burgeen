<?php
/**
 * Campaign title.
 *
 * @package funder
 * @since funder 1.5
 */

global $campaign;
?>

<div class="title <?php echo '' == $campaign->author() ? '' : 'title-two'; ?> pattern-<?php echo rand(1,4); ?>">
		<?php the_title() ;?>
		
		<?php /*?><?php if ( '' != $campaign->author() ) : ?>
		<h3><?php printf( __( 'By %s', 'funder' ), esc_attr( $campaign->author() ) ); ?></h3>
		<?php endif; ?><?php */?>
</div>