<?php 
// funder Contact from 
add_shortcode( 'wpg_contact', 'wpg_contact_from' );

function wpg_contact_from() {

if(isset($_POST['submitted'])) {

			//Check to see if the honeypot captcha field was filled in
			if(trim($_POST['checking']) !== '') {
				$captchaError = true;
			} else {
			
				//Check to make sure that the name field is not empty
				if(trim($_POST['widget-contactName']) === '') {
					$nameError = 'Please enter your name';
					$hasError = true;
				} else {
					$name = trim($_POST['widget-contactName']);
				}
				
				//Check to make sure sure that a valid email address is submitted
				if(trim($_POST['widget-email']) === '')  {
					$emailError = 'Please enter a valid email address';
					$hasError = true;
				} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['widget-email']))) {
					$emailError = 'Please enter a valid email address';
					$hasError = true;
				} else {
					$email = trim($_POST['widget-email']);
				}
					
				//Check to make sure comments were entered	
				if(trim($_POST['widget-comments']) === '') {
					$commentError = 'Please enter message';
					$hasError = true;
				} else {
					if(function_exists('stripslashes')) {
						$comments = stripslashes(trim($_POST['widget-comments']));
					} else {
						$comments = trim($_POST['widget-comments']);
					}
				}
					
				//If there is no error, send the email
				if(!isset($hasError)) {

					$emailTo =  $data['text_contact_email']; 
					$subject = 'Contact Form Submission from '.$name;
					$sendCopy = isset($_POST['sendCopy'])? trim($_POST['sendCopy']): false;
					$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
					$headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
					
					@mail($emailTo, $subject, $body, $headers);

					if($sendCopy == true) {
						$subject = 'You emailed Your Name';
						$headers = 'From: Your Name <noreply@somedomain.com>';
						mail($email, $subject, $body, $headers);
					}

					$emailSent = true;

				}
			}
		} 
		
		
		?>
		
		<script type="text/javascript">
			/* Contact Form Widget*/
			jQuery(document).ready(function() {
				jQuery('form#contact-us-form').submit(function() {
					jQuery('form#contact-us-form .error').remove();
					var hasError = false;
					jQuery('.requiredField').each(function() {
						if(jQuery.trim(jQuery(this).val()) == '') {
							var labelText = jQuery(this).prev('label').text();
							jQuery(this).parent().append('<div class="error"><?php echo __('* Require','cp_front_end'); ?></div>');
							hasError = true;
							
						} else if(jQuery(this).hasClass('email')) {
							var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
							if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
								var labelText = jQuery(this).prev('label').text();
								jQuery(this).parent().append('<div class="error"><?php echo __('* Require','cp_front_end'); ?></div>');
								hasError = true;
							}
						}
					});
					
					if(!hasError) {
						jQuery('form#contact-us-form li.buttons button').fadeOut('normal', function() {
							jQuery(this).parent().append('<?php echo __('Please Wait...','cp_front_end'); ?>');
						});
						var formInput = jQuery(this).serialize();
						jQuery.post(jQuery(this).attr('action'),formInput, function(data){
							jQuery('form#contact-us-form').slideUp("fast", function() {				   
								jQuery(this).before('<p class="thanks"><?php echo __('Thanks! Your email was sent','cp_front_end'); ?></p>');
							});
						});
					}
					
					return false;
					
				});
			});			
		</script>			
				
					<?php if(isset($hasError) || isset($captchaError)) { ?>
						<p class="error"><?php echo get_option(THEME_NAME_S.'_translator_sending_error_contact_widget','There was an error submitting the form.'); ?><p>
					<?php } ?>
                    
						<div class="contacts">
                        <div class="bborder">
                            <p><strong><?php _e('Send Us a <span class="green">Message</span>','wpg')?></strong></p>
                        </div>
                        
								<form action="<?php the_permalink(); ?>" id="contact-us-form" method="post" class="row-fluid message">
									<div class="controls controls-row">
											<input type="text" name="widget-contactName" id="widget-contactName" value="<?php if(isset($_POST['widget-contactName'])) echo $_POST['widget-contactName'];?> Name*" class="requiredField inputp search-query span4" />
										<?php if(!empty($nameError) && $nameError != '') { ?>
												<span class="error"><?php echo $nameError;?></span>
										<?php } ?>
											<input type="text" name="widget-email" id="widget-email" value="<?php if(isset($_POST['widget-email']))  echo $_POST['widget-email'];?> E-mail*" class="requiredField email inputp search-query span4" />
										<?php if(!empty($emailError) && $emailError != '') { ?>
												<span class="error"><?php echo $emailError;?></span>
										<?php } ?>
                                        	<input type="text" name="widget-url" id="widget-url" value="<?php if(isset($_POST['widget-url']))  echo $_POST['widget-url'];?> URL" class="requiredField url inputp search-query span4" />
									    <div class="clear"></div>
											<textarea name="widget-comments" id="redex" class="requiredField inputp search-query span12" ><?php if(isset($_POST['widget-comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['widget-comments']); } else { echo $_POST['widget-comments']; } } ?>Message*</textarea>
										<?php if(!empty($commentError) && $commentError != '') { ?>
												<span class="error"><?php echo $commentError;?></span> 
										<?php } ?>
									      <div class="clear"></div>
                                        <div class="tmargin20">
									    <button type="submit" class="btn" name="submit" value="submit" id="contact_submit"><strong><?php echo __('Send Message','cp_front_end'); ?></strong></button>
                                         </div>
            							<div id="error_placeholder" class="form-message text-green"></div>
									</div>
								</form>
						</div>
						<div class="clear alignleft"></div>								
		<?php 
}