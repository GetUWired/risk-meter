<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

/**
 * Disable admin bar on the frontend of your website
 * for subscribers.
 */
function themeblvd_disable_admin_bar() { 
    if ( ! current_user_can('edit_posts') ) {
        add_filter('show_admin_bar', '__return_false'); 
    }
}
add_action( 'after_setup_theme', 'themeblvd_disable_admin_bar' );
 
/**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function themeblvd_redirect_admin(){
    if ( ! defined('DOING_AJAX') && ! current_user_can('edit_posts') ) {
        wp_redirect( site_url() . '/risk-meter/' );
        exit;       
    }
}
add_action( 'admin_init', 'themeblvd_redirect_admin' );


function custom_login_logo() {

	$login = '<style type="text/css">';
	$login .= 'body.login div#login h1 a {';
	$login .= 'background-image: url("http://realriskmeter.com/wp-content/themes/hello-elementor/assets/images/TMN-real_risk_meter_logo_large.jpg");';
	$login .= 'width: 100%;';
	$login .= 'background-size: cover;';	
	$login .= 'margin: 0 auto;';		
	$login .= '}';

	$login .= 'body.login div#login form input[type="submit"] {';
	$login .= 'background: #E8160D;';
	$login .= 'border-color: #E8160D;';
	$login .= '}';

	$login .= 'body.login div#login form input[type=text]:focus {border-color: #E8160D; box-shadow: 0 0 0 1px #E8160D;}';
	$login .= 'body.login div#login form input[type=password]:focus {border-color: #E8160D; box-shadow: 0 0 0 1px #E8160D;}';
	$login .= 'body.login div#login form input[type=checkbox]:focus {border-color: #E8160D; box-shadow: 0 0 0 1px #E8160D;}';
	$login .= 'body.login div#login form button.wp-hide-pw .dashicons {color: #E8160D;}';	
	$login .= 'input[type=checkbox]:checked::before {content: "\2713 "; color: #000;}';
	$login .= 'input[type=checkbox]:checked {border-color:#E8160D;}';	
	$login .= 'input[type=checkbox] {border-color:#E8160D;}';	
	$login .= '</style>';
	echo $login;


}


add_action('login_enqueue_scripts', 'custom_login_logo');
