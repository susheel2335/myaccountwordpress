<?php

function register(){
 
  if (is_user_logged_in())
    {
     
        
      echo "<div class='no-login'>Already logged in and  visit this page </div>";
    }

    else{
        
    
    if (isset($_POST['submit']) and $_POST['action'] == 'user_register')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
            
        //   $username= sanitize_text_field($_POST['user_nicename']);
        //   $email= sanitize_text_field($_POST['user_email']);
        //   $password= sanitize_text_field($_POST['password']);
           
           
           
           
           
            global $wpdb;
// Check username is present and not already in use  
  
 $username= sanitize_text_field($_POST['user_nicename']);
  
if (strpos($username, ' ') !== false)  
    {  
    $errors['username'] = "Sorry, no spaces allowed in usernames";  
    }  
  
if (empty($username))  
    {  
    $errors['username'] = "Please enter a username";  
    }  
elseif (username_exists($username))  
    {  
    $errors['username'] = "Username already exists, please try another";  
    }  
  
// Check email address is present and valid  
  
  $email= sanitize_text_field($_POST['user_email']);
  
if (!is_email($email))  
    {  
    $errors['email'] = "Please enter a valid email";  
    }  
elseif (email_exists($email))  
    {  
    $errors['email'] = "This email address is already in use";  
    }  
  
// Check password is valid  
  
if (0 === preg_match("/.{6,}/", $_POST['password']))  
    {  
    $errors['password'] = "Password must be at least six characters";  
    }  
  // issue 71 remove garbase 
// Check password confirmation_matches  
  
// if (0 !== strcmp($_POST['password'], $_POST['password_confirmation']))  
//     {  
//     $errors['password_confirmation'] = "Passwords do not match";  
//     }  
  
// Check terms of service is agreed to  
  
// if ($_POST['terms'] != "Yes")  
//     {  
//     $errors['terms'] = "You must agree to Terms of Service";  
//     }  
  // issue 85  incorrect way to check if 
if (0 === count($errors))  
    {  
    $password = $_POST['password'];  
    $new_user_id = wp_create_user($username, $password, $email);  
  
    // You could do all manner of other things here like send an email to the user, etc. I leave that to you.  
  
	
	// issue 94 what is use of this success variable and where it is used
	
    $success = 1;  
    header('Location:' . get_bloginfo('url') . '/login/?success=1&u=' . $username);  

    
     $user_info = get_userdata($new_user_id);
    // create md5 code to verify later
    $code = md5(time());
    // make it into a code to send it to user via email
    $string = array('id'=>$new_user_id, 'code'=>$code);
    // create the activation code and activation status
    update_user_meta($new_user_id, 'is_activated', 0);
    update_user_meta($new_user_id, 'activation_code', $code);
    // create the url
    $url = get_site_url(). '/login?act=' .base64_encode( serialize($string));
    // basically we will edit here to make this nicer
    $html = 'Please click the following links <br/><br/> <a href="'.$url.'">'.$url.'</a>';
    // send an email out to user

	
	
	$account_activation_link= $html ;
	
	  $_SESSION['account_activation_link'] =  $account_activation_link;
		
		
wp_mail($email,"Registered Successfully"  ,print_r( $_SESSION['account_activation_link'],true));
        //     if ( email_exists($email) == false) {

        // // Create the new user
        // $user_id = wp_create_user($username, $password, $email);
        //   wp_mail($email, $password ,"Registered Successfully<br> Your Password is: ".$password);
        // }
        
        
        
    }
    
     print_r($errors);
        }
        
        else {
            
    ?>

 <form method="POST" action="" name="user_register" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

    <div class="mb-3">   
  <label for="user_nicename"><?php _e("Name"); ?></label><br>
   
 <input type="text" name="user_nicename" id="user_nicename" >
  
 <br></div><br>
 
     <div class="mb-3">   
  <label for="user_email"><?php _e("Email"); ?></label><br>
   
 <input type="text" name="user_email" id="user_email" >
  
 <br></div><br>
 
 
     <div class="mb-3">   
  <label for="password"><?php _e("Password"); ?></label><br>
   
 <input type="text" name="password" id="password" >
  
 <br></div><br>
 
    <div class="mb-3">   
  <label for="password"><?php _e("Confirm Password"); ?></label><br>
   
 <input type="password" name="password_confirmation" id="password_confirmation" >
  
 <br></div><br>
 
 <div class="mb-3">   
    <input name="terms" id="terms" type="checkbox" value="Yes">  
        <label for="terms">I agree to the Terms of Service</label>  
  
 <br></div><br>
  
  
     
  
     
<input  type="submit"  name="submit" value="<?php _e('Register', 'aistore') ?>"/>
<input type="hidden" name="action" value="user_register" />

 </form>
 
 <?php
        }
    }
}
