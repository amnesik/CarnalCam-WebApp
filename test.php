<?php

include('utilities/config.php');
include('utilities/functions.php');


echo curl('POST','/auth/signin',array("identifier"=>"carnal","password"=>"carnal"),null);

