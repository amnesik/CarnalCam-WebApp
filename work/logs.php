<?php

function getLogs(){
	$rep = curl('GET','/log',null,$_SESSION['token']);
	return json_decode($rep,true);
}