<?php
	
    /*
    Plugin Name: GUW Risk Meter User
    Description: Creates a wordpress user for a protected page 
    Version: 1.0
    Author: GetUWired
    Author URI: http://getuwired.com
    */


    // TODO use one of these functions for reactivating an account after a failed payment
	// TODO need to test these once on live account
	// TODO Finish the new account email from Wordpress
    function guw_create_user()
    {

        if (!empty($_POST['key']) && $_POST['key'] !== '759e89b262c1f9cb79e6d5460385aff7e40aa2ff485e166779083d41d1283fb1d39593466ffb9ac04d860721442aa35f') {
            echo "hey this is not working";
            die('No Access');
        }

        $user = null;
        $email = $_POST['email'] ?? null;
        //not sure where username is coming from
        $user_name = $_POST['user_name'] ?? null; 

        if ($email) {

            $userId = email_exists($email); // Returns user ID on success or false
            if ($userId) {
                $user = get_user_by('id', $userId);
                $reset = true;

            } else {
                // Create new user if not alreayd a user
                $random_password = wp_generate_password($length = 20, $include_standard_special_chars = false);
                $result = wp_create_user($user_name, $random_password, $email);
                if (is_wp_error($result)) {
//                    $error = $result->get_error_message();
                    $userId = null;


                } else {
                    $user = get_user_by('id', $result);
                    $reset = false;

                }
            }

            if ($user) {
                $user->set_role('subscriber');
                // Send email with password
                guw_send_password_reset_email($reset);
                http_response_code(200);
                return true;
            }
        }
        http_response_code(200);
        return true;
    }


    add_action('admin_post_nopriv_guw_create_user', 'guw_create_user');
    add_action('admin_post_guw_create_user', 'guw_create_user');

    function guw_remove_access_to_site_after_failed_payment()
    {
        if (!empty($_POST['key']) && $_POST['key'] !== 'eaa5703138ebc7a8fc2ce49f59f1f7b4f38ab2099d03981db3d36854ae71e3506c024045a000ea50bcdb427fefe41983') {
            die('No Access');
        }

        $user = null;
        $email = $_POST['email'] ?? null;
        if ($email) {
            $userId = email_exists($email); // Returns user ID on success or false
            if ($userId) {
                $user = get_user_by('id', $userId);
            }

            if ($user) {
                $user->set_role('locked_user');
                http_response_code(200);
                return true;
            }
        }
        http_response_code(200);
        return true;
    }

    add_action('admin_post_guw_remove_access_to_site_after_failed_payment', 'guw_remove_access_to_site_after_failed_payment');

    function guw_create_locked_role()
    {
        add_role('locked_user', __('Locked'), [
            'read'       => false,
            'edit_posts' => false,
        ]);
    }

    add_action('init', 'guw_create_locked_role');

    function guw_send_password_reset_email($reset)
    {

            $subject = 'Here are your login credentials';

            $msg = '<p>Hello, ' . $user_name . ', </p>';
            if ($reset) {  
                $msg .= '<p>Thank you for updating your credit card information for the Risk Meter. ';                
            } else {
                $msg .= '<p>Thank you for signing up for our Risk Meter. ';           
            }          
            $msg .= 'Here are your login credentials: </p>';
            $msg .= '<p>Email: ' . $email . '</p>';
            $msg .= '<p>Password: ' . $random_password . '</p>'; 
            $msg .= '<p>Click on the link below to login to access the Risk Meter.</p>';
            $msg .= '<p><a href="http://realriskmeter.com/wp-login.php">Real Risk Meter</a></p>';                   
            wp_mail($email, $subject, $msg);

    }





