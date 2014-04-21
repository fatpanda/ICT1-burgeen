<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) { ?>
<p class="nocomments"><?php echo __( 'This post is password protected. Enter the password to view comments.', 'wpg' ); ?></p>
<?php
return;
}
?>
 
<!-- You can start editing here. -->
 
<?php if ( have_comments() ) : ?>
 
<div class="navigation">
    <div class="alignleft"><?php previous_comments_link() ?></div>
    <div class="alignright"><?php next_comments_link() ?></div>
</div>

     <h4 class="decoration text-center"><span class="nobacgr">Ask a Question</span></h4>
        
<ul class="comments-list">
    <?php wp_list_comments('callback=gt_comments'); ?>
</ul>

<?php else : // this is displayed if there are no comments so far ?>
 
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php echo __( 'Comments are closed.', 'wpg' ); ?></p>
 
<?php endif; ?>
<?php endif; ?>
 
<?php if ('open' == $post->comment_status) : ?>

 <div id="asc_a_question_form">
          <h3 class="text-center asc_question_form_name">Ask a <span class="h3_quest">Question</span></h3>
          <div class="form_question">
            <div class="row-fluid">
              <div class="controls controls-row message">
               <?php comment_form(); ?>
               </div>
            </div>
          </div>
        </div>


<?php endif; // if you delete this the sky will fall on your head ?>