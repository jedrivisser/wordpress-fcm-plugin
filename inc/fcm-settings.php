<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(isset( $_POST['savekey'] ) && wp_verify_nonce($_REQUEST['savekey'], 'mode_save_access_key')  && current_user_can('administrator')){
	
	$option_name = 'fcm_access_key_option';
	$new_value = sanitize_text_field($_POST['access_key']);
	 
	if ( get_option( $option_name ) !== false ) {
	 
		// The option already exists, so update it.
		update_option( $option_name, $new_value );
	 
	} else {
	 
		// The option hasn't been created yet, so add it with $autoload set to 'no'.
		$deprecated = null;
		$autoload = 'no';
		add_option( $option_name, $new_value, $deprecated, $autoload );
	}
	
	//show message
  echo "<div class='update-nag notice'>
      <p>Your settings saved successfully.</p>
  </div>";
}	
?>
<link href="<?php echo plugins_url( 'css/bootstrap.min.css', dirname(__FILE__) );?>" type="text/css" rel="stylesheet" />
<script type='text/javascript' src='<?php echo plugins_url( 'js/form.validation.js', dirname(__FILE__) );?>'></script>
<div class="wrap">
<h2>Google FCM settings</h2>
<br clear="all" />
<form method="post" action="admin.php?page=ss-fcm-settings" enctype="multipart/form-data">
<table bgcolor="#FFFFFF" class="table table-striped table-bordered table-hover wp-list-table widefat fixed  pages">
	<tr>
	<th>
	<input type="text" name="access_key" id="access_key" value="<?php echo get_option('fcm_access_key_option'); ?>" placeholder="API access key from Google Firebase Console"/><span id="access_key_error" style="color:red;"></span>
	</th>
	</tr>
	<tr>
	<th align="left">
	 <?php 
	  wp_nonce_field('mode_save_access_key','savekey'); 
	  submit_button( 'Save settings', 'primary', 'save-settings', false );
	  ?>
	</th>
	</tr>    
</table>
</form>
<br clear="all" /> 
<div>
<h1>How to find your google firebase access key</h1>
<br>
<b>STEP 1:</b> Go to <a href="https://console.firebase.google.com/" target="_blank"><b>Firebase Console</b></a>
<br><br>
<b>STEP 2:</b> Select your Project
<br><br>
<b>STEP 3:</b> Click on Settings icon and select <b>Project Settings</b>
<br><br>
<img src="<?php echo plugins_url( 'images/screen-1.png', dirname(__FILE__) );?>" border="0">
<br><br>
<b>STEP 4:</b> Select <b>CLOUD MESSAGING</b> tab->server key [your key must be registered for (/topics/all)]
<br><br>
<img src="<?php echo plugins_url( 'images/screen-2.png', dirname(__FILE__) );?>" border="0">
</div> 		
</div>	