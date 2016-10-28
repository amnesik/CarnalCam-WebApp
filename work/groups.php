<?php

function getUsers(){
        $rep = curl('GET','/user',null,$_SESSION['token']);
        if($rep[0] == "401") return "Session Timeout, Please authenticate...";
        else if($rep[0] == "404") return "Error: curl returned 404 error...";
        else if($rep[0] != "200") return "Error: Server connection issues....";
        else return json_decode($rep[1],true);
}

function getGroups(){
        $rep = curl('GET','/userGroup',null,$_SESSION['token']);
        if($rep[0] == "401") return "Session Timeout, Please authenticate...";
        else if($rep[0] == "404") return "Error: curl returned 404 error...";
        else if($rep[0] != "200") return "Error: Server connection issues....";
        else return json_decode($rep[1],true);
}


function addGroup($name,$users){
	if($name!=""){
		$datas = array(
			"name" => $name,
			"members" => $users
		);
		$rep = curl('POST','/userGroup',$datas,$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
                else if($rep[0] == "404") return "Error: curl returned 404 error...";
                else if($rep[0] != "201") return "Error: Server connection issues....";
                else return true;
	}
	else return "Error: specify group name";
}

function deleteGroup($id){
	if($id != ""){
		$rep = curl('DELETE',"/usergroup/$id",null,$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else return "Error: no group id specified...";
}

function delGroupUser($user,$group){
	if($user != "" && $group != ""){
		$rep = curl('DELETE',"/usergroup/removeuser/$group",array("members"=>$user),$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else return "Error: user and id are null....";
}

function addGroupUser($user,$group){
	if($user != "" && $group != ""){
		$rep = curl('POST',"/device/removegroup/$device",array("groups"=>$group),$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else return "Error: group and id are null....";
}