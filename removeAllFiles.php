<?php 


	
$connection = ssh2_connect($_GET['deviceid'], 22);
ssh2_auth_password($connection, 'pi', 'raspberry');


$stream = ssh2_exec($connection, 'rm /opt/pi/*.mp4');
echo "Files Deleted Succesfully ".$stream;

?>