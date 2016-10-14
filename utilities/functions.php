<?php
/**********************/
/*
function curl(METHOD,URL,[DATAS],TOKEN) return json


		      */
/*********************/


function curl($method, $url, $datas, $token){
	global $api_url;
	global $curl_bin;
	$headers = "";
	$post_datas = "";
	$method = escapeshellarg($method);
	$url = escapeshellarg(str_replace("//","/",$api_url.$url));

	//post request format
	if(count($datas)>0){
		$post_datas = "";
		foreach($datas as $name => $value){
			$post_datas .= urlencode($name)."=".urlencode($value).'&';
		}
		$post_datas = '--data '.escapeshellarg(substr($post_datas,0,-1));
	}

	//base64 validation for token
	if(preg_match('/^[a-zA-Z0-9\.\/\r\n+]*={0,2}$/', $token) && strlen($token)>0){
		$headers = "-H 'Authorization: JWT $token'";
	}
	$curl_rep =  shell_exec("$curl_bin -X $method $url $headers $post_datas -v 2>&1");
        $status_code = substr($curl_rep,strpos($curl_rep,"< HTTP/1.1 ")+11,3);
	$reponse = explode("left intact\n",$curl_rep)[1];
	return array($status_code,$reponse);
}
