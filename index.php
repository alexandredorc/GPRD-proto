<?php
session_start();

if(isset($_COOKIE['auto_login'])){
	$_SESSION['user_id']=$_COOKIE['auto_login'];
	include 'login/config.php';

	$data=user_single_query('user_id',$_SESSION['user_id'],$bdd);

	if($data!=false){
		$_SESSION['name']=$data['name'];
		$_SESSION['email']=$data['email'];
		header('Location: compo/index.php');
	}
}else{
	session_destroy();
	header('Location: login/login.php');
}?>

