<?php


/*
Plugin Name: Wordpress My Account
Version:  1.0
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Wordpress Users is a list of all registers users and users profile.  
*/

include_once dirname(__FILE__) . '/login.php';
 include_once dirname(__FILE__) . '/register.php';
 
add_shortcode('myaccountlogin', 'login');
add_shortcode('myaccountregister', 'register');