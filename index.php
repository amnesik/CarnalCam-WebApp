<?php

session_start();

include("utilities/config.php");
include("utilities/functions.php");




/****** VIEWS *********/
$body = 'views/'.$_GET['page'];
include('views/squelette');


?>
