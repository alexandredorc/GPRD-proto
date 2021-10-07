<?php 
session_destroy();
setcookie('auto_login',NULL ,time()-1,'/', null, false, true);
header('Location: login.php');
?>