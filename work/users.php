<?php

function getUsers(){
	$rep = curl('GET','/user',null,$_SESSION['token']);
	if($rep[0] == "401") return "Session Timeout, Please authenticate...";
	else if($rep[0] == "404") return "Error: curl returned 404 error";
	else if($rep[0] != "200") return "Error: Server connection issues....";
        else return json_decode($rep[1],true);

}
