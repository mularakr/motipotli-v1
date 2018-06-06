<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	$mysqli = new mysqli('localhost', 'root', 'admin', 'motipotli');
	if ($mysqli->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$tournamentsDetails="SELECT * FROM device_tokens order by id desc LIMIT 1";
	$result = $mysqli->query($tournamentsDetails);	
	$getDetails =mysqli_fetch_assoc($result);
	//echo "<pre>";print_r($result2);die;	
	$getToken =$getDetails['token'];   
	$response = getData('app_sendMailStartEndNotification', $getToken,'');   
	$data = json_decode($response, true);
	function getData($api, $access_token = "", $data = array()) {
		$curl = curl_init();
		$base_url = "http://192.168.3.31/motipotli/api/v1.0/";
		//$base_url = "http://albastini.com/api/api/v1.0/";
		curl_setopt_array($curl, array(
		CURLOPT_URL => $base_url . $api,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode($data),
		CURLOPT_HTTPHEADER => array(
		"Authorization: " . $access_token,
		"cache-control: no-cache"
		),
		));	
		$response = curl_exec($curl);
		$err = curl_error($curl);
		print_r($response);die;
		curl_close($curl);
		if ($err) {
			return json_encode(array('status' => 'failure'));
		} else {
			return $response;
		}
	}
