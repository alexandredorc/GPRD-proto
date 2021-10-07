<?php
session_start();

if (isset($_SESSION['temp_name'])){
	$name=$_SESSION['temp_name'];
	$email=$_SESSION['temp_email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>registration page</title>
	<link rel="stylesheet" href="../public/styles.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	
	<div class="body-register">
		<div class="head">
			<h3>veuillez renseigner un mail qui n'est pas déjà enregistré</h3>
			<h1>Page d'inscription</h1>
		</div>
		<div class="body">
		<form action="registration.php" method="post">
			<div class="input-register">
				nom d'utilisateur:<br/>
				<input type="text" name="name" value="<?php echo (isset($name))?$name:'';?>">
			</div>
			<div class="input-register">
			adresse email:<br/>
			<input type="email" name="email" value="<?php echo (isset($email))?$email:'';?>">
			</div>
			<div class="input-register">
			mot de passe:<br/>
			<input type="password" name="password">
			</div>
			<div class="input-register">
			confirmation mot de passe:<br/>
			<input type="password" name="repassword">
			</div>
			<div class="input-register">

			<div class="register-submit"><button type="submit" class="btn btn-primary">Register</button></div>
			
		</form>
		</div>
		<div class="foot">
		<?php 
			if(isset($_GET['erreur']) && $_GET['erreur']==1){?> 
			veuillez renseignez un nom d'utilisateur <?php } 
			elseif(isset($_GET['erreur']) && $_GET['erreur']==2){ ?>
			veuillez renseignez une adresse mail   <?php } 
			elseif(isset($_GET['erreur']) && $_GET['erreur']==3){ ?>
			veuillez renseignez un mot de passe  <?php } 
			elseif(isset($_GET['erreur']) && $_GET['erreur']==4){ ?>
			la confirmation du mot de passe n'est pas bonne <?php } 
			elseif(isset($_GET['erreur']) && $_GET['erreur']==5){ ?>
			le mail que vous avez retré est déjà enregistré <?php } 
			?>
		</div>
	</div>
	
</body>
</html>
