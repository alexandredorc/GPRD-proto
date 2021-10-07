<?php
session_start();
if(isset($_POST['email']) && isset($_POST['password']))
{
	include 'config.php';
	echo isset($dbb);
    $email = htmlspecialchars($_POST['email']); 
    $password = htmlspecialchars($_POST['password']);
    if($email !== "" && $password !== "")
	{
		$req = $bdd->query('select user_id,name from user where email=\''.$email.'\' and password=\''.$password.'\'');
		if($data= $req->fetch())
		{
				$_SESSION['email']=$email;
				$_SESSION['name']=$data['name'];
				$_SESSION['user_id']=$data['user_id'];
				header('Location: ../prod/index.php');
		}
		else{
			header('Location: login.php?erreur=1');
		}
	}
	else{
		header('Location: login.php?erreur=2');
	}
}
?>
