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

function addUser($firstName,$lastName,$email,$user,$pass1,$pass2,$idgroup){
	if(strlen($firstName)>1 && strlen($lastName)>1 && strlen($user)>1){
		if($pass1 == $pass2){
			if(strlen($pass1)>5){
				$datas = array(
					"username" => $user,
					"password" => $pass1,
					"email" => $email,
					"firstName" => $firstName,
					"lastName" => $lastName,
					"groups" => $idgroup
				);
				$rep = curl('POST','/user',$datas,$_SESSION['token']);
				if($rep[0] == "401") return "Session Timeout, Please authenticate...";
			        else if($rep[0] == "404") return "Error: curl returned 404 error...";
			        else if($rep[0] != "201") return "Error: Server connection issues....";
				else return true;
			}
			else return "Error: Password must be at least 6 characters long";
		}
		else return "Error: both passwords are not same...";
	}
	else return "Error: Please specify all champs...";
}

function deleteUser($id){
	if($id != ""){
		$rep = curl('DELETE',"/user/$id",null,$_SESSION['token']);
		if($rep[0] == "401") return "Session Timeout, Please authenticate...";
		else if($rep[0] == "404") return "Error: curl returned 404 error...";
		else if(!strstr($rep[0],"20")) return "Error: Server connection issues....";
		else return true;
	}
	else return "Error: no user id specified...";
}

function delGroupUser($user,$group){
	if($user != "" && $group != ""){
		$rep = curl('DELETE',"/user/removegroup/$user",array("groups"=>$group),$_SESSION['token']);
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