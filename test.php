<?php

include('utilities/config.php');
include('utilities/functions.php');



echo curl('DELETE','/user/me',array("field"=>"popo","pipi"=>"caca"),'qlhflkjf6789876hjomksgomjqdfhuskh+fghjk');


echo curl('DELETE','/user/me',null,null);


echo curl('DELETE','/user/me',array("pipi"=>"caca"),'qlhflkjf6789876hjomksgomjqdfhuskh+fghjk');

