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
	if(isset($_SESSION["admin"]) && ($_GET['page'] != "login")){ if($_SESSION["admin"] == true) {
		if($_GET['page'] == 'users'){
			include('work/users.php');
			if(isset($_POST['createUser'])){
				$added = addUser($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['username'],$_POST['pass1'],$_POST['pass2'],$_POST['groups']);
			}
			if(isset($_POST['deleteUser'])){
				$deleted = deleteUser($_POST['id']);
			}
			if(isset($_POST['delgroupuser'])){
				$deleted = delGroupUser($_POST['user'],$_POST['group']);
			}
			//addusergroup
			if(isset($_POST['addusergroup'])){
				$added = addGroupUser($_POST['user'],$_POST['groups']);
			}
			$users = getUsers();
			$groups = getGroups();
		}


		if($_GET['page'] == 'groups'){
			include('work/groups.php');
					
			if(isset($_POST['createGroup'])){
				$added = addGroup($_POST['name'],$_POST['users'],$_POST['role'],$_POST['devicegroups']);
			}
			
			if(isset($_POST['deleteGroup'])){
				$deleted = deleteGroup($_POST['id']);
			}
			if(isset($_POST['delgroupuser'])){
				$deleted = delGroupUser($_POST['user'],$_POST['group']);
			}
			if(isset($_POST['addusergroup'])){
				$added = addGroupUser($_POST['users'],$_POST['group']);
			}
			if(isset($_POST['deldevicegroup'])){
				$deleted = delDeviceGroup($_POST['group'],$_POST['devicegroup']);
			}
			if(isset($_POST['adddevicegroup'])){
				$added = addDeviceGroup($_POST['group'],$_POST['devicegroups']);
			}
			if(isset($_POST['role']) && isset($_POST['group'])){
				$updated = updateRole($_POST['group'],$_POST['role']);
			}
			
			$users = getUsers();
			$groups = getGroups();
			$devicegroups = getDevicesGroups();
		}

		if($_GET['page'] == 'devices'){
			include('work/devices.php');
			if(isset($_POST['deleteDevice'])){
				$deleted = deleteDevice($_POST['id']);
			}
			if(isset($_POST['delgroupdevice'])){
				$deleted = delGroupDevice($_POST['device'],$_POST['group']);
			}
			if(isset($_POST['adddevicegroup'])){
				$added = addGroupDevice($_POST['device'],$_POST['groups']);
			}
			$devices = getDevices();
			$groups = getDevicesGroups();
		}
		
		if($_GET['page'] == 'devicesgroups'){
			include('work/devicesgroups.php');
			if(isset($_POST['createGroup'])){
				$added = addGroup($_POST['name'],$_POST['devices']);
			}
			
			if(isset($_POST['deleteGroup'])){
				$deleted = deleteGroup($_POST['id']);
			}
			if(isset($_POST['delgroupdevice'])){
				$deleted = delGroupDevice($_POST['device'],$_POST['group']);
			}
			if(isset($_POST['adddevicegroup'])){
				$added = addGroupDevice($_POST['devices'],$_POST['group']);
			}
			$devices = getDevices();
			$groups = getDevicesGroups();
		}
		
		if($_GET['page'] == "logs"){
			include('work/logs.php');
			$logs = getLogs();
		}
		
		if($_GET['page'] == 'logout'){
			session_destroy();
			header('Location: /');
			die();
		}
	} else $view = "401"; }
	
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
