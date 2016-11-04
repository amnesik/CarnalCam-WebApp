<?php

function getUsers(){
        $rep = curl('GET','/user',null,$_SESSION['token']);
        return json_decode($rep,true);
}

function getGroups(){
        $rep = curl('GET','/userGroup',null,$_SESSION['token']);
        return json_decode($rep,true);
}

function getDevicesGroups(){
        $rep = curl('GET','/deviceGroup',null,$_SESSION['token']);
        return json_decode($rep,true);
}

function addGroup($name,$users,$role,$devicegroups){
	if($name!=""){
		if($role == "viewer" || $role = "manager"){
			$datas = array(
				"name" => $name,
				"members" => $users,
				"role" => $role,
				"devicesgroups" => $devicegroups
			);
			$rep = curl('POST','/userGroup',$datas,$_SESSION['token']);
			return true;
		}
	}
	else $GLOBALS['errors'] =  "Error: specify group name";
}

function deleteGroup($id){
	if($id != ""){
		$rep = curl('DELETE',"/usergroup/$id",null,$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: no group id specified...";
}

function delGroupUser($user,$group){
	if($user != "" && $group != ""){
		$rep = curl('DELETE',"/usergroup/removeuser/$group",array("members"=>$user),$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: user and id are null....";
}

function addGroupUser($users,$group){
	if(count($users)>0 && $group != ""){
		foreach($users as $user){
			$rep = curl('POST',"/userGroup/$group/members/$user",null,$_SESSION['token']);
		}
		return true;
	}
	else $GLOBALS['errors'] =  "Error: group and id are null....";
}

function delDeviceGroup($group,$devicegroup){
	if($devicegroup != "" && $group != ""){
		$rep = curl('DELETE',"/usergroup/removedevicegroup/$group",array("devicegroups"=>$devicegroup),$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: devicegroup and group are null....";
}


function addDeviceGroup($group,$devicegroups){
	if(count($devicegroups)>0 && $group != ""){
		foreach($devicegroups as $devicegroup){
			$rep = curl('POST',"/userGroup/$group/devicesgroups/$devicegroup",null,$_SESSION['token']);
		}
		return true;
	}
	else $GLOBALS['errors'] =  "Error: group and deviceGroup are null....";
}

function updateRole($group,$role){
	if($role != "" && $group != ""){
		$rep = curl('POST',"/userGroup/$group",array("role" => $role),$_SESSION['token']);
	}
	else $GLOBALS['errors'] =  "Error: role and group are null....";
}