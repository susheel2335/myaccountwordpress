<?php

function register(){
 
   if (is_user_logged_in())
    {
     
        
      return "<div class='no-login'>Already logged in and  visit this page </div>";
    }

    
    if (isset($_POST['submit']) and $_POST['action'] == 'user_register')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
            
           $username= sanitize_text_field($_POST['user_nicename']);
           $email= sanitize_text_field($_POST['user_email']);
           $password= sanitize_text_field($_POST['password']);
           
            if ( email_exists($email) == false) {

        // Create the new user
        $user_id = wp_create_user($username, $password, $email);
          wp_mail($email, $password ,"Registered Successfully");
        }
        
        
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
 
     
<input  type="submit"  name="submit" value="<?php _e('Register', 'aistore') ?>"/>
<input type="hidden" name="action" value="user_register" />

 </form>
 
 <?php
        }
}