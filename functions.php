<?php
/*
Plugin Name: WP Security Login Notification
Plugin URI: http://neoptin.com/
Description: Sends an email to the administrator each time a user logs in successfully or fails to connect. The email contains some useful information including IP adress and user agent.
Version: 1.0
Author: Neoptin
Author URI: http://neoptin.com/
Text Domain: wp-security-login-notification
Domain Path: /languages

Copyright 2013 Neoptin

*/


// multi-language
function wpsln_init() {
  $plugin_dir = basename(dirname(__FILE__));
  load_plugin_textdomain( 'wpsln', false, $plugin_dir . '/languages/' );
}
add_action('plugins_loaded', 'wpsln_init');



/*******************************************************************
 *
 * CORE FUNCTIONS
 *
 *******************************************************************/

if(!function_exists('wpsln_neo_get_ip')){
  function wpsln_neo_get_ip(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      //check ip from share internet
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      //to check ip is pass from proxy
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}



/*******************************************************************
 *
 * CORE FUNCTIONS
 *
 *******************************************************************/

/**
 * Log for each log in
 *
 * @param str $user_user_login
 * @param object $user
 */
function wpsln_log_wp_user_login( $user_user_login, $user ) {
  
  // init var
  $user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? esc_html($_SERVER['HTTP_USER_AGENT']) : '');
  $referrer = (isset($_SERVER['HTTP_REFERER'])      ? esc_html($_SERVER['HTTP_REFERER']) : '');
  
  
  //===============================================
  // Send email
  //===============================================
  $admin_email = get_bloginfo('admin_email');
  $site_info = sprintf('%1$s (%2$s)', get_bloginfo('name'), get_bloginfo('wpurl'));
  
  // generate email core
  $header = 'From: "'.$admin_email.'" <'.$admin_email.'>'. "\r\n";
  $header .= "Content-type: text/html; charset: ".get_bloginfo('charset')."\r\n";
  $email_subject = sprintf(__('Login of the user %1$s on the website %2$s', 'wpsln'), $user->user_login, $site_info);
  
  $body_message = sprintf(__('Hello a user has logged in on the website %1$s. Here are the details of this access:', 'wpsln'),$site_info).'<br />'."\n";
  $body_message .= sprintf(__('User: %1$s', 'wpsln'),          $user->user_login).'<br />'."\n";
  $body_message .= sprintf(__('User email: %1$s', 'wpsln'),    $user->user_email).'<br />'."\n";
  $body_message .= sprintf(__('Date: %1$s', 'wpsln'),          date_i18n('Y-m-d H:i:s')).'<br />'."\n";
  $body_message .= sprintf(__('IP: %1$s', 'wpsln'),            wpsln_neo_get_ip()).'<br />'."\n";
  $body_message .= sprintf(__('User agent: %1$s', 'wpsln'),    $user_agent).'<br />'."\n";
  $body_message .= sprintf(__('HTTP referrer: %1$s', 'wpsln'), $referrer).'<br />'."\n";

  // send email
  wp_mail($admin_email, $email_subject, $body_message, $header);
  
}
add_action( 'wp_login', 'wpsln_log_wp_user_login', '60', 2 );


/**
 * Redirect user to the login form if the login failed
 *
 * @param str $username
 */
function wpsln_log_wp_user_login_fail( $username ) {
  
  // init var
  $user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? esc_html($_SERVER['HTTP_USER_AGENT']) : '');
  $referrer = (isset($_SERVER['HTTP_REFERER'])      ? esc_html($_SERVER['HTTP_REFERER']) : '');
  
  
  //===============================================
  // Send email
  //===============================================
  $admin_email = get_bloginfo('admin_email');
  $site_info = sprintf(__('%1$s (%2$s)', 'wpsln'), get_bloginfo('name'), get_bloginfo('wpurl'));

  // generate email core
  $header = 'From: "'.$admin_email.'" <'.$admin_email.'>'. "\r\n";
  $header .= "Content-type: text/html; charset: ".get_bloginfo('charset')."\r\n";
  $email_subject = sprintf(__('/!\ Error : login failed on %1$s', 'wpsln'), $site_info);

  $body_message = sprintf(__('Hello, someone just failed to log in on %1$s. Here are the details:', 'wpsln'),$site_info).'<br />'."\n";
  $body_message .= sprintf(__('Login: %1$s', 'wpsln'), $username).'<br />'."\n";
  $body_message .= sprintf(__('Date: %1$s', 'wpsln'),          date_i18n('Y-m-d H:i:s')).'<br />'."\n";
  $body_message .= sprintf(__('IP: %1$s', 'wpsln'),            wpsln_neo_get_ip()).'<br />'."\n";
  $body_message .= sprintf(__('User agent: %1$s', 'wpsln'),    $user_agent).'<br />'."\n";
  $body_message .= sprintf(__('HTTP referrer: %1$s', 'wpsln'), $referrer).'<br />'."\n";

  // send email
  wp_mail($admin_email, $email_subject, $body_message, $header);
  
}
add_action( 'wp_login_failed', 'wpsln_log_wp_user_login_fail' );


/**
 * Additional links on the plugin page
 * 
 * @param array $links
 * @param str $file
 */
function wpsln_plugin_row_meta($links, $file) {
  if ($file == plugin_basename(__FILE__)) {
    $links[] = '<a href="http://neoptin.com/donate/">' . __('Donate','wpsln') . '</a>';
  }
  return $links;
}
add_filter('plugin_row_meta', 'wpsln_plugin_row_meta',10,2);
