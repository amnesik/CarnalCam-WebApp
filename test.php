<?php
session_start();
include('utilities/config.php');
include('utilities/functions.php');


//var_dump(curl('POST','/auth/signin',array("identifier"=>"carnal","password"=>"carnal"),null));

echo $_SESSION["token"];
