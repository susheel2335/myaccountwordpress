<?php

function login(){
    
     if (is_user_logged_in())
    {
     
        
      return "<div class='no-login'>Already logged in and  visit this page </div>";
    }
    
    
    if (isset($_POST['submit']) and $_POST['action'] == 'user_login')
        {

            if (!isset($_POST['aistore_nonce']) || !wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce_action'))
            {
                return _e('Sorry, your nonce did not verify', 'aistore');
                exit;
            }
            
            
         
           $email= sanitize_text_field($_POST['user_email']);
           $password= sanitize_text_field($_POST['password']);
           
        $ar=array();
	$user = apply_filters( 'authenticate', null, $email, $password );

	 if ( is_wp_error($user) ) {
 
 $ar['Error']=0;
 $ar['Message']=$user;
}
else
{
	
 $ar['Error']=1;
 $ar['Message']="Login details are correct";
 $ar['user_id']=$user->ID ;
 $user_id=$user->ID ;
 wp_set_current_user( $user_id, $user->user_login );
    wp_set_auth_cookie( $user_id );
    do_action( 'wp_login', $user->user_login, $user );
   
   
	
} 
	 

return  $ar ;
        
        
        }
        
        else {
            
    ?>

 <form method="POST" action="" name="user_login" enctype="multipart/form-data"> 

<?php wp_nonce_field('aistore_nonce_action', 'aistore_nonce'); ?>

  
 
     <div class="mb-3">   
  <label for="user_email"><?php _e("Email"); ?></label><br>
   
 <input type="text" name="user_email" id="user_email" >
  
 <br></div><br>
 
 
     <div class="mb-3">   
  <label for="password"><?php _e("Password"); ?></label><br>
   
 <input type="text" name="password" id="password" >
  
 <br></div><br>
 
     
<input  type="submit"  name="submit" value="<?php _e('Login', 'aistore') ?>"/>
<input type="hidden" name="action" value="user_login" />

 </form>
 
 <?php
        }
        
    
}