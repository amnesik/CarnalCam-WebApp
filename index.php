<?php

session_start();

include("utilities/config.php");
include("utilities/functions.php");

$errors = "";

if(isset($_GET['page'])){
	/******* CONTROLLERS ********/
	if($_GET['page'] == "login"){
		if(isset($_POST['login']) && isset($_POST['pass'])){
			if($_POST['login']!="" && $_POST['pass']!=""){
				include('work/login.php');
				$id = identification($_POST['login'],$_POST['pass']);
				if(is_string($id)) $errors = $id;
				else {
					$_SESSION["token"] = $id["token"];
					$_SESSION["usename"] = $id["user"]["username"];
					$_SESSION["email"] = $id["user"]["email"];
					$_SESSION["firstName"] = $id["user"]["firstName"];
					$_SESSION["lastName"] = $id["user"]["lastName"];
                                        $_SESSION["id"] = $id["user"]["id"];
					$_SESSION["admin"] = $id["user"]["isAdmin"];
					header('Location: /?page=users');
					die();
				}
			}
			else $errors = "Please specify username and password";
		}
	}
	if($_GET['page'] == 'users'){
		include('work/users.php');
		if(isset($_POST['createUser'])){
			$added = addUser($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['username'],$_POST['pass1'],$_POST['pass2'],$_POST['groups']);
			if(is_string($added)) $errors = $added;
		}
		if(isset($_POST['deleteUser'])){
			$deleted = deleteUser($_POST['id']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['delgroupuser'])){
			$deleted = delGroupUser($_POST['user'],$_POST['group']);
			if(is_string($deleted)) $errors = $deleted;
		}
		//addusergroup
		if(isset($_POST['addusergroup'])){
			var_dump($_POST['groups']);
			$added = addGroupUser($_POST['user'],$_POST['groups']);
			if(is_string($added)) $errors = $added;
		}
		$users = getUsers();
		if(is_string($users)) $errors .= $users;
		$groups = getGroups();
		if(is_string($groups)) $errors .= $groups;
	}


	if($_GET['page'] == 'groups'){
		include('work/groups.php');
                
		if(isset($_POST['createGroup'])){
			$added = addGroup($_POST['name'],$_POST['users']);
			if(is_string($added)) $errors = $added;
		}
		
		if(isset($_POST['deleteGroup'])){
			$deleted = deleteGroup($_POST['id']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['delgroupuser'])){
			$deleted = delGroupUser($_POST['user'],$_POST['group']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['addusergroup'])){
			$added = addGroupUser($_POST['users'],$_POST['group']);
			if(is_string($added)) $errors = $added;
		}
		$users = getUsers();
        if(is_string($users)) $errors .= $users;
        $groups = getGroups();
        if(is_string($groups)) $errors .= $groups;
	}

	if($_GET['page'] == 'devices'){
		include('work/devices.php');
		if(isset($_POST['deleteDevice'])){
			$deleted = deleteDevice($_POST['id']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['delgroupdevice'])){
			$deleted = delGroupDevice($_POST['device'],$_POST['group']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['adddevicegroup'])){
			$added = addGroupDevice($_POST['device'],$_POST['groups']);
			if(is_string($added)) $errors = $added;
		}
		$devices = getDevices();
        if(is_string($devices)) $errors .= $devices;
        $groups = getDevicesGroups();
        if(is_string($groups)) $errors .= $devicesgroups;
	}
	
	if($_GET['page'] == 'devicesgroups'){
		include('work/devicesgroups.php');
		if(isset($_POST['createGroup'])){
			$added = addGroup($_POST['name'],$_POST['devices']);
			if(is_string($added)) $errors = $added;
		}
		
		if(isset($_POST['deleteGroup'])){
			$deleted = deleteGroup($_POST['id']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['delgroupdevice'])){
			$deleted = delGroupDevice($_POST['device'],$_POST['group']);
			if(is_string($deleted)) $errors = $deleted;
		}
		if(isset($_POST['adddevicegroup'])){
			$added = addGroupDevice($_POST['devices'],$_POST['group']);
			if(is_string($added)) $errors = $added;
		}
		$devices = getDevices();
        if(is_string($devices)) $errors .= $devices;
        $groups = getDevicesGroups();
        if(is_string($groups)) $errors .= $groups;
	}
	
	if($_GET['page'] == 'logout'){
		session_destroy();
		header('Location: /');
		die();
	}
	/********* VIEWS ************/
	if(!isset($view)){
		if(in_array($_GET['page'],scandir('views'))) $view = $_GET['page'];
		else $view = "404";
		if($view != "login" && $view != "404" && !isset($_SESSION['id'])) $view = "401";
	}

}
else $view = "login";
if(isset($_SESSION["admin"])) if($_SESSION["admin"]==true && $view == "login"){ /*$view = "users";*/ header('Location: /?page=users'); die();}
include('views/template');


?>
