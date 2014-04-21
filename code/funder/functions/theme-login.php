<?php 
/*-----------------------------------------------------------------------------------*/
/*	Login / Register from
/*  Package: Funder
/*	ver:     1.0
/*	Author:  Nasir Hayat
/*-----------------------------------------------------------------------------------*/


function login_block() { ?>
<?php if( is_user_logged_in() )  { ?>

<div class="bleft inline login"> <a class="login-link" href="<?php echo wp_logout_url( get_permalink() ); ?>">
  <?php _e('Logout','crunchpress')?>
  </a> </div>
<?php }else { 
				if(get_option('users_can_register')) 
			{ ?>
<?php }?>
<div class="bleft inline login"> <a id="login-trigger" class="login-link" href="#">
  <?php _e('Login','crunchpress')?>
  </a>
  <div id="login-content">
    <form id="loginform" action="<?php  echo site_url('wp-login.php', 'login_post') ?>" method="post">
      <ul id="login_list">
        <li>
          <input type="text" name="log" id="user_login" placeholder="Login" class="inputp search-query " value="<?php echo esc_attr($user_login); ?>" />
        </li>
        <li>
          <input type="password" name="pwd" id="user_pass" placeholder="Password" class="inputp search-query " value=""  />
        </li>
        <?php do_action('login_form'); ?>
        <?php /*?> <li class="rememberme-check-box">
                            <input name="rememberme" type="checkbox" id="rememberme" value="forever" />&nbsp;Remember you?
                            <input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>/?action=user" />
                        </li><?php */?>
        <li class="submit"> <a href="<?php echo home_url(); ?>/?action=user" title="Lost your password? Reset it here..." class="log-pass" id="password-reset">
          <?php _e('Forgot Password?','funder')?>
          </a>
          <input class="button-log-green" type="submit" id="signin" value="Sign In" />
        </li>
      </ul>
    </form>
  </div>
</div>
<?php }	?>
<div class="bleft bright inline login"><a href="<?php echo home_url(); ?>/#register" id="reg-link" class="login-link">Register</a></div>
<?php } ?>
