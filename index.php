<?php

session_start();

include("utilities/config.php");
include("utilities/functions.php");




/****** VIEWS *********/
if(in_array($_GET['page'],scandir('views'))) $body = 'views/'.$_GET['page'];
else $body = "404";

include('views/template');


?>
