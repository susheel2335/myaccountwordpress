<?php
 // issue 1 remove garbase 
// add_action( 'init', 'verify_user_code' );
// function verify_user_code(){
//     if(isset($_GET['act'])){
//         $data = unserialize(base64_decode($_GET['act']));
//         $code = get_user_meta($data['id'], 'activation_code', true);
//         // verify whether the code given is the same as ours
//         if($code == $data['code']){
//             // update the user meta
//             update_user_meta($data['id'], 'is_activated', 1);
//             wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! ', 'text-domain' )  );
//         }
//     }
// }

function login(){
    
     if (is_user_logged_in())
    {
        
      // issue 2 correct message show profile page here 
        
      echo "<div class='no-login'>Already logged in and  visit this page </div>";
    }
    
    
    else{
	    
	     // issue 4 remove garbase 
        
    //       if(isset($_GET['act'])){
    //     $data = unserialize(base64_decode($_GET['act']));
    //     $code = get_user_meta($data['id'], 'activation_code', true);
    //     // verify whether the code given is the same as ours
    //     if($code == $data['code']){
    //         // update the user meta
    //         update_user_meta($data['id'], 'is_activated', 1);
    //          echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>";  
    //   exit();
    //         // wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! ', 'text-domain' )  );
    //     }
    // }
    
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
 $ar['Message']="logged in successfully";
	
	 // issue 5  two time data was taken from the object get data only 1 time if require 
 $ar['user_id']=$user->ID ;
 $user_id=$user->ID ;
 wp_set_current_user( $user_id, $user->user_login );
    wp_set_auth_cookie( $user_id );
    do_action( 'wp_login', $user->user_login, $user );
	
	// issue 6 can we ask user to set redirect from the setting or some where 
     echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>";  
       exit();
        

	
} 
	 
// issue 7 remove extra print from here
 print_r($ar);
        
        
        }
        // issue 8 no need for the else statement 
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
    
}
