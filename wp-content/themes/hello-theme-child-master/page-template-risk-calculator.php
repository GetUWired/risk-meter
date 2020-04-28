<?php 

/*
Template Name: Calculator
*/


ob_clean();
ob_start();

?>


<!-- <?php 

//error_reporting(E_ALL);
//ini_set('display_errors', 1); 

?> -->

<style type="text/css">
	div.page-content {
		text-align: center;
	}
</style>

<?php 

	$site = get_site_url();
	
	if(is_user_logged_in()) {
		loadPage();
	} else {
		$redirect = $site .'/wp-login.php';
		wp_redirect($redirect);
		exit;
	}

	
	function loadPage() 
	{

		if( current_user_can('locked_user') ){
			$url = $site .'/password-denied/';
			wp_redirect($url);
			exit;
		} elseif (current_user_can('subscriber') || current_user_can('administrator')) {

			get_header();

			// found this header in WP, but the shortcode isn't working
			// echo do_shortcode('[elementor-template id="12"]');
			$content = '<style>iframe {margin: 25px 0;} .link_account {border: 1px solid #c36; padding: .5rem 1rem; font-size: 1rem; border-radius: 3px;} .link_account:hover {color: #fff !important;background-color: #c36;text-decoration: none;}</style>';
			$content .= '<div class="page-content">';
			$content .= '<iframe src="https://realriskmeter.incomyz.com/" width="100%" height="80%" ></iframe>';
			$content .= '<a class="link_account" href="http://realriskmeter.com/my-account/">My Account</a>';
			$content .= '</div>';

			echo $content;
		} else {

			$sales_page = "https://u8cadteu.pages.infusionsoft.net";
			wp_redirect($sales_page);
			exit;
		}
	}



?>

<div id="main">



</div>

<?php 

get_footer();

?>