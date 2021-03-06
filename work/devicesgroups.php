<?php

function getDevices(){
	$rep = curl('GET','/device',null,$_SESSION['token']);
	return json_decode($rep,true);
}

function getDevicesGroups(){
        $rep = curl('GET','/deviceGroup',null,$_SESSION['token']);
        return json_decode($rep,true);
}

function addGroup($name,$users){
	if($name!=""){
		$datas = array(
			"name" => $name,
			"devices" => $users
		);
		$rep = curl('POST','/deviceGroup',$datas,$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: specify group name";
}

function deleteGroup($id){
	if($id != ""){
		$rep = curl('DELETE',"/deviceGroup/$id",null,$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else $GLOBALS['errors'] =  "Error: no group id specified...";
}


function delGroupDevice($device,$group){
	if($device != "" && $group != ""){
		$rep = curl('DELETE',"/devicegroup/removedevice/$group",array("devices"=>$device),$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: group and id are null....";
}

function addGroupDevice($devices,$group){
	if(count($devices)>0 && $group != ""){
		foreach($devices as $device){
			$rep = curl('POST',"/deviceGroup/$group/devices/$device",null,$_SESSION['token']);
		}
		return true;
	}
	else $GLOBALS['errors'] =  "Error: group and id are null....";
}