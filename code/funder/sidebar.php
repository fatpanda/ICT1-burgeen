	<aside id="sidebar" class="span4 sidebar_descr last">
	
	<?php if (is_page()): ?>
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Page Sidebar') ) : else : ?>
		<?php endif; ?>
	<?php else: ?>
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Page Sidebar') ) : else : ?>
		<?php endif; ?>
	<?php endif; ?>	
	
	</aside><!-- end #sidebar -->