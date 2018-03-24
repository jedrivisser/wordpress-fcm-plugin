<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(isset( $_POST['sendmsg'] ) && wp_verify_nonce($_REQUEST['sendmsg'], 'mode_send_msg')  && current_user_can('administrator')){

	$title = sanitize_text_field($_POST['title']);
	$msgtext = sanitize_text_field($_POST['msg']);
	// API access key from Google API's Console
	$googleFcmKey = get_option('fcm_access_key_option');
	define( 'API_ACCESS_KEY', $googleFcmKey );
	//firebase topic
	$to = '/topics/all';
	//firebase url 
	$url = 'https://fcm.googleapis.com/fcm/send';
	// prep the bundle
	$msg = array
	(
		'body' 	=> $msgtext,
		'title'		=> $title,
		'vibrate'	=> 1,
		'sound'		=> 1,
	);
	$fields = array
	(
		'to' => $to,
		'notification' => $msg
	);
	 //send request to firebase
	 $response = wp_remote_post($url, array(
        'method' => 'POST',
		'blocking' => true,
		'headers' => array( 'Authorization' => 'key='. API_ACCESS_KEY,'Content-Type' => 'application/json' ),
        'httpversion' => '1.0',
        'sslverify' => false,
        'body' => json_encode($fields),
		)
    );
	//response from google firebase
	$result = $response['response']['message'];
	
	// if response success
	if($result=='OK'){
	echo "<div class='update-nag notice'>
     <p>Message has been sent successfully.</p>
   </div>";
	}else{
	// Print Debug Information
	echo "<div class='update-nag error'>
     <p>".'Error: '.$response['response']['code'].'-'.$response['response']['message']."</p>
   </div>";
	}
}	
?>
<link href="<?php echo plugins_url( 'css/bootstrap.min.css', dirname(__FILE__) );?>" type="text/css" rel="stylesheet" />
<script type='text/javascript' src='<?php echo plugins_url( 'js/form.validation.js', dirname(__FILE__) );?>'></script>
<div class="wrap">
<h2>Send new notification (Google Firebase Cloud Messaging)</h2>
<br clear="all" />
<form method="post" action="admin.php?page=ss-fcm" enctype="multipart/form-data">
<table bgcolor="#FFFFFF" class="table table-striped table-bordered table-hover wp-list-table widefat fixed  pages">
	<tr>
	<th>Subject</th>
	<th><input type="text" name="title" id="title" value="" placeholder="Please enter Subject" required="required"/>
	<span id="title_error" style="color:red;"></span></th>
	</tr>
	<tr>
	<th>Notification text</th>
	<th><textarea name="msg" id="msg" style="height:200px;" placeholder="Please enter Notification text" required="required"></textarea>
	<span id="description_error" style="color:red;"></span></th>
	</tr>
	<tr>
	<th>&nbsp;</th>
	<th align="left">
	 <?php wp_nonce_field('mode_send_msg','sendmsg'); ?>
	 <?php submit_button('Send'); ?>
	</th>
	</tr>
</table>
</form>    
<br clear="all" />  		
</div>	