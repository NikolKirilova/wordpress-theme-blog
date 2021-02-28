<?php

function load_stylesheets()
{  

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',
        array(), false, 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('stylesheet', get_template_directory_uri() . '/style.css', '', 1, 'all');
    wp_enqueue_style('stylesheet');


}
add_action('wp_enqueue_scripts', 'load_stylesheets');



function include_bootstrap(){

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true );
}

add_action('wp_enqueue_scripts', 'include_bootstrap');

function load_javascript()
{

    wp_register_script('custom', get_template_directory_uri() . '/app.js', 'jquery', 1, true );
    wp_enqueue_script('custom');
}

add_action('wp_enqueue_scripts', 'load_javascript');

//Add support
add_theme_support('menus');
add_theme_support('post-thumbnails');

//Register some menus
register_nav_menus(
    array(

        'top-menu' => 'Top Menu',
    )
    );

//Add image sizes
add_image_size('post_image', 600, 550, false);


//Add a widget
register_sidebar(

    array(

        'name' => 'Page Sidebar',
        'id' => 'page-sidebar',
        'class' => '',
        'before_title' => '<h4>',
        'after_title' => '</h4>',

    )
    );


register_sidebar(

    array(
    
            'name' => 'Blog Sidebar',
            'id' => 'blog-sidebar',
            'class' => '',
            'before_title' => '<h4>',
            'after_title' => '</h4>',
    
        )
        );

        //Register navwalker

function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );


// user registration login form
function micode_registration_form() {
 
	// only show the registration form to non-logged-in members
	if(!is_user_logged_in()) {
 
		// check if registration is enabled
		$registration_enabled = get_option('users_can_register');
 
		// if enabled
		if($registration_enabled) {
			$output = micode_registration_fields();
		} else {
			$output = __('User registration is not enabled');
		}
		return $output;
	}
}
add_shortcode('register_form', 'micode_registration_form');

// registration form fields
function micode_registration_fields() {
	
	ob_start(); ?>	
		<h3 class="micode_header"><?php _e('Register New Account'); ?></h3>
		
		<?php 
		// show any error messages after form submission
		vicode_register_messages(); ?>
		
		<form id="micode_registration_form" class="micode_form" action="" method="POST">
			<fieldset>
				<p>
					<label for="micode_user_Login"><?php _e('Username'); ?></label>
					<input name="micode_user_login" id="micode_user_login" class="micode_user_login" type="text"/>
				</p>
				<p>
					<label for="micode_user_email"><?php _e('Email'); ?></label>
					<input name="micode_user_email" id="micode_user_email" class="micode_user_email" type="email"/>
				</p>
				<p>
					<label for="micode_user_first"><?php _e('First Name'); ?></label>
					<input name="micode_user_first" id="micode_user_first" type="text" class="micode_user_first" />
				</p>
				<p>
					<label for="micode_user_last"><?php _e('Last Name'); ?></label>
					<input name="micode_user_last" id="micode_user_last" type="text" class="micode_user_last"/>
				</p>
				<p>
					<label for="password"><?php _e('Password'); ?></label>
					<input name="micode_user_pass" id="password" class="password" type="password"/>
				</p>
				<p>
					<label for="password_again"><?php _e('Password Again'); ?></label>
					<input name="micode_user_pass_confirm" id="password_again" class="password_again" type="password"/>
				</p>
				<p>
					<input type="hidden" name="micode_csrf" value="<?php echo wp_create_nonce('micode-csrf'); ?>"/>
					<input type="submit" value="<?php _e('Register Your Account'); ?>"/>
				</p>
			</fieldset>
		</form>
	<?php
	return ob_get_clean();
}

// register a new user
function vicode_add_new_user() {
    if (isset( $_POST["micode_user_login"] ) && wp_verify_nonce($_POST['micode_csrf'], 'micode-csrf')) {
      $user_login		= $_POST["micode_user_login"];	
      $user_email		= $_POST["micode_user_email"];
      $user_first 	    = $_POST["micode_user_first"];
      $user_last	 	= $_POST["micode_user_last"];
      $user_pass		= $_POST["micode_user_pass"];
      $pass_confirm 	= $_POST["micode_user_pass_confirm"];
      
      // this is required for username checks
      require_once(ABSPATH . WPINC . '/registration.php');
      
      if(username_exists($user_login)) {
          // Username already registered
          micode_errors()->add('username_unavailable', __('Username already taken'));
      }
      if(!validate_username($user_login)) {
          // invalid username
          micode_errors()->add('username_invalid', __('Invalid username'));
      }
      if($user_login == '') {
          // empty username
          micode_errors()->add('username_empty', __('Please enter a username'));
      }
      if(!is_email($user_email)) {
          //invalid email
          micode_errors()->add('email_invalid', __('Invalid email'));
      }
      if(email_exists($user_email)) {
          //Email address already registered
          micode_errors()->add('email_used', __('Email already registered'));
      }
      if($user_pass == '') {
          // passwords do not match
          micode_errors()->add('password_empty', __('Please enter a password'));
      }
      if($user_pass != $pass_confirm) {
          // passwords do not match
          micode_errors()->add('password_mismatch', __('Passwords do not match'));
      }
      
      $errors = micode_errors()->get_error_messages();
      
      // if no errors then cretate user
      if(empty($errors)) {
          
          $new_user_id = wp_insert_user(array(
                  'user_login'		=> $user_login,
                  'user_pass'	 		=> $user_pass,
                  'user_email'		=> $user_email,
                  'first_name'		=> $user_first,
                  'last_name'			=> $user_last,
                  'user_registered'	=> date('Y-m-d H:i:s'),
                  'role'				=> 'subscriber'
              )
          );
          if($new_user_id) {
              // send an email to the admin
              wp_new_user_notification($new_user_id);
              
              // log the new user in
              wp_setcookie($user_login, $user_pass, true);
              wp_set_current_user($new_user_id, $user_login);	
              do_action('wp_login', $user_login);
              
              // send the newly created user to the home page after logging them in
              wp_redirect(home_url()); exit;
          }
          
      }
  
  }
}
add_action('init', 'vicode_add_new_user');

// used for tracking error messages
function micode_errors(){
    static $wp_error; // global variable handle
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function vicode_register_messages() {
	if($codes = micode_errors()->get_error_codes()) {
		echo '<div class="micode_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = micode_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}	
}

  function wpb_cookies() { 
// Time of user's visit
$visit_time = date('F j, Y g:i a');
 
// Check if cookie is already set
if(isset($_COOKIE['wpb_visit_time'])) {
 
// Do this if cookie is set 
function visitor_greeting() {
 
// Use information stored in the cookie 
$lastvisit = $_COOKIE['wpb_visit_time'];
 
$string .= 'You last visited our website '. $lastvisit .'. Check out whats new'; 
 
return $string;
}   
 
} else { 
 
// Do this if the cookie doesn't exist
function visitor_greeting() { 
$string .= 'New here? Check out these resources...' ;
return $string;
}   
 
// Set the cookie
setcookie('wpb_visit_time',  $visit_time, time()+31556926);
}
 
// Add a shortcode 
add_shortcode('greet_me', 'visitor_greeting');
 
} 
add_action('init', 'wpb_cookies');