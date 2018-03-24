<?php
  function send_push($msgtext, $title) {
    // API access key from Google API's Console
    $googleFcmKey = get_option('fcm_access_key_option');

    $fcmTopic = get_option('fcm_topic_option');

    //firebase topic
    $to = '/topics/'.$fcmTopic;
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
      'headers' => array( 'Authorization' => 'key='. $googleFcmKey,'Content-Type' => 'application/json' ),
          'httpversion' => '1.0',
          'sslverify' => false,
          'body' => json_encode($fields),
      )
      );

    return $response;
  }
?>