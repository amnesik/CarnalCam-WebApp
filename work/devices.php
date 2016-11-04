<?php

function getDevices(){
	$rep = curl('GET','/device',null,$_SESSION['token']);
	return json_decode($rep,true);
}

function getDevicesGroups(){
        $rep = curl('GET','/deviceGroup',null,$_SESSION['token']);
        return json_decode($rep,true);
}

function deleteDevice($id){
	if($id != ""){
		$rep = curl('DELETE',"/device/$id",null,$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: no user id specified...";
}

function delGroupDevice($device,$group){
	if($device != "" && $group != ""){
		$rep = curl('DELETE',"/device/removegroup/$device",array("groups"=>$group),$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] = "Error: group and id are null....";
}

function addGroupDevice($device,$groups){
	if($device != "" && count($groups)>0){
		foreach($groups as $group){
			$rep = curl('POST',"/device/$device/groups/$group",null,$_SESSION['token']);
		}
		return true;
	}
	else $GLOBALS['errors'] =  "Error: group and id are null....";
}
