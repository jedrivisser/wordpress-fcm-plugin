<?php
/*
Plugin Name: Send FCM notifications
Plugin URI: http://dselva.co.in/
Description: Easily send notifications to all of your android app users by using google Firebase Cloud Messaging.
Version: 1.0
Author: Team dselva
Author URI: http://dselva.co.in

GNU General Public License
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function ss_fcm(){
add_menu_page('FCM notifications', 'FCM notifications', 'manage_options', 'ss-fcm', 'ss_manage_fcm', plugins_url( 'images/mail-icon.png', __FILE__  ),10);

add_submenu_page( 'ss-fcm', 'Settings', 'FCM settings', 'manage_options', 'ss-fcm-settings', 'ss_manage_fcm_settings');
}
add_action( 'admin_menu', 'ss_fcm' );

function ss_manage_fcm(){
		
include('inc/send-msg.php');

}

function ss_manage_fcm_settings(){
		
include('inc/fcm-settings.php');

}