<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_myConnection = "192.168.34.5";
$database_myConnection = "media_server";
$username_myConnection = "root";
$password_myConnection = "raspberry";
$myConnection = mysql_pconnect($hostname_myConnection, $username_myConnection, $password_myConnection) or trigger_error(mysql_error(),E_USER_ERROR); 
?>