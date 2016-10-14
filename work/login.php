<?php

function identification($login,$password){
	
	$rep = curl('POST','/auth/signin',array("identifier"=>$login,"password"=>$password),null);
	if($rep[0] == "401") return "Error: Bad Username/Password...";
	else if($rep[0] != "200") return "Error: Server connection issues....";
	else return json_decode($rep[1],true)["token"];
}
