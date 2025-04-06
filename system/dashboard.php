<?php

$role=$_SESSION['userrole'];
$dashboard="users/dashboard/$role.php";
include $dashboard;

?>