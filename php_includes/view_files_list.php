<?php 

$connection = ssh2_connect($_GET['deviceid'], 22);
ssh2_auth_password($connection, 'pi', 'raspberry');


$stream = ssh2_exec($connection, 'ls -1 /opt/pi/ ');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
echo "Videos on :".$_GET['deviceid']."<br />" ;
echo "--------------------------------------<br />";
$str = stream_get_line($stream_out,1000);
//echo str_replace("b","<br />",$str);

//print $new;
echo nl2br($str,false);



?>