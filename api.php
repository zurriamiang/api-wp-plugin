<?php 
/*
Plugin Name: API by mj group
Plugin URI: https://maremjaya.com
Description: This is plugin wordpress for connect api
Version: 1.0.0
Author: Qodr Magetan
Author URI: https://qodr.or.id
License: GPL2
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

/*
	- http://bppkad.magetan.go.id/wp-admin/admin-ajax.php?action=curl&type=get&url=http://google.com
*/

function curl_api(){
	if(!empty($_REQUEST['type'])){
		if($_REQUEST['type'] == 'get'){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $_REQUEST['url']); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			$response = trim(curl_exec($ch));
			curl_close($ch);
			die($response);
		}else if($_REQUEST['type'] == 'post'){
			$curl = curl_init();
		    $req = $_REQUEST;
		    unset($req['url']);
		    set_time_limit(0);
		    $url = $_REQUEST['url'];
		    $req = http_build_query($req);
		    curl_setopt_array($curl, array(
		        CURLOPT_URL => $url,
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => "",
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 30,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => "POST",
		        CURLOPT_POSTFIELDS => $req,
		        CURLOPT_SSL_VERIFYPEER => false,
		        CURLOPT_SSL_VERIFYHOST => false,
		        CURLOPT_CONNECTTIMEOUT => 0,
		        CURLOPT_TIMEOUT => 10000
		    ));
		    $response = curl_exec($curl);
		    $err = curl_error($curl);
		    curl_close($curl);
		    if ($err) {
		        echo "cURL Error #:" . $err; die();
		    } else {
		    	die($response);
		    }
		}else{
			die('type curl tidak ada!');
		}
	}else{
		die(':)');
	}
}

add_action( 'wp_ajax_curl', 'curl_api' );
add_action( 'wp_ajax_nopriv_curl', 'curl_api' );