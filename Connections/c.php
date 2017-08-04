<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_c = "localhost";
$database_c = "opticien";
$username_c = "root";
$password_c = "";
$c = @mysql_pconnect($hostname_c, $username_c, $password_c) or trigger_error(mysql_error(),E_USER_ERROR); 
?>