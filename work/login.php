<?php

function identification($login,$password){
	$rep = curl('POST','/auth/signin',array("identifier"=>$login,"password"=>$password),null);
	return json_decode($rep,true);
}
