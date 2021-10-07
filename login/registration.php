<?php
session_start();
$_SESSION['temp_name']=$_POST['name'];
$_SESSION['temp_email']=$_POST['email'];
if($_POST['name']!==""){
	if($_POST['email']!==""){
		if($_POST['password']==="" || $_POST['repassword']===""){
			header('Location: register.php?erreur=3');
		}elseif($_POST['password']!=$_POST['repassword']){
			header('Location: register.php?erreur=4');
		}else{
			include 'config.php';
			$data=user_single_query('email',$_SESSION['temp_email'],$bdd);
			if($data){
				header('Location: register.php?erreur=5');
			}
			else{
			$req = $bdd->prepare('INSERT INTO user (name, email, password) VALUES(:name, :email, :password)');
			$req->execute(array(
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'password' => $_POST['password']
			));
			header('Location: login.php');
			}
		}
	}else{
		header('Location: register.php?erreur=2');
	}
}else{
	header('Location: register.php?erreur=1');
}
?>
