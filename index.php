<?php

session_start();

include("utilities/config.php");
include("utilities/functions.php");

$errors = "";

if(isset($_GET['page'])){
	/******* CONTROLLERS ********/
	if($_GET['page']) == "login"){
		if(isset($_POST['login']) && isset($_POST['pass'])){
			include('work/login.php');
			identification($_POST['login'],$_POST['pass']);
		}
		else $errors = "Please specify username and password";
	}


	/********* VIEWS ************/
	if(in_array($_GET['page'],scandir('views'))) $view = $_GET['page'];
	else $view = "404";

}
else $view = "login";

include('views/template');


?>
