<?php

function getDevices(){
	$rep = curl('GET','/device',null,$_SESSION['token']);
	if($rep[0] == "401") return "Session Timeout, Please authenticate...";
	else if($rep[0] == "404") return "Error: curl returned 404 error...";
	else if($rep[0] != "200") return "Error: Server connection issues....";
        else return json_decode($rep[1],true);
}

function getDevicesGroups(){
        $rep = curl('GET','/deviceGroup',null,$_SESSION['token']);
        if($rep[0] == "401") return "Session Timeout, Please authenticate...";
        else if($rep[0] == "404") return "Error: curl returned 404 error...";
        else if($rep[0] != "200") return "Error: Server connection issues....";
        else return json_decode($rep[1],true);
}

function deleteDevice($id){
	if($id != ""){
		$rep = curl('DELETE',"/device/$id",null,$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else return "Error: no user id specified...";
}

function delGroupDevice($device,$group){
	if($device != "" && $group != ""){
		$rep = curl('DELETE',"/device/removegroup/$device",array("groups"=>$group),$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else return "Error: group and id are null....";
}
