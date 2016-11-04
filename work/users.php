<?php

function getUsers(){
	$rep = curl('GET','/user',null,$_SESSION['token']);
	return json_decode($rep,true);
}

function getGroups(){
        $rep = curl('GET','/userGroup',null,$_SESSION['token']);
        return json_decode($rep,true);
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
				return true;
			}
			else $GLOBALS['errors'] =  "Error: Password must be at least 6 characters long";
		}
		else $GLOBALS['errors'] =  "Error: both passwords are not same...";
	}
	else $GLOBALS['errors'] =  "Error: Please specify all champs...";
}

function deleteUser($id){
	if($id != ""){
		$rep = curl('DELETE',"/user/$id",null,$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: no user id specified...";
}

function delGroupUser($user,$group){
	if($user != "" && $group != ""){
		$rep = curl('DELETE',"/user/removegroup/$user",array("groups"=>$group),$_SESSION['token']);
		return true;
	}
	else $GLOBALS['errors'] =  "Error: user and id are null....";
}

function addGroupUser($user,$groups){
	if($user != "" && count($groups)>0){
		foreach($groups as $group){
			$rep = curl('POST',"/user/$user/groups/$group",null,$_SESSION['token']);
		}
		return true;
	}
	else $GLOBALS['errors'] =  "Error: group and id are null....";
}