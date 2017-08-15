<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Server_HTC = "localhost";
$database_Server_HTC = "htc";
$username_Server_HTC = "root";
$password_Server_HTC = "";
$Server_HTC = mysql_pconnect($hostname_Server_HTC, $username_Server_HTC, $password_Server_HTC) or trigger_error(mysql_error(),E_USER_ERROR); 
?>