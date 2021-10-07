<?php
session_start();

if (isset($_SESSION['name'])){
	include('logout.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Page de connexion</title>
	<link rel="stylesheet" href="../public/styles.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="body-center">
		<div class="body">
			<h1>Page de connexion</h1>
			<div class="input">
			<form action="check.php" method="post" autocomplete="off">
				<div class="login-input">
					Adresse E-mail:
					<input type="text" name="email" ><br/>
				</div>
				<div class="login-input">
					Mot de Passe:
					<input type="password" name="password" >
				</div>
				<div class="login-submit">
					<button type="submit" class="btn btn-primary"> Connexion </button>
					<div class="register"><a href="register.php">register</a></div>

				</div>
			</form>
			</div>
		</div>
		<div class="foot">
		<?php if(isset($_GET['erreur'])){ ?>
			<div class="alertes">
				<?php
				if(isset($_GET['erreur']) && $_GET['erreur']==1){
				?>	
				<p>
					le mot de passe et l'indentifiant ne correspondent pas
				</p>
				<?php
				}elseif(isset($_GET['erreur']) && $_GET['erreur']==2){
				?>
				<p>
					veuillez renseignez un indentifiant et un mot de passe
				</p>
				<?php } ?>
				<div class="excl"><img src = "../public/exclamation-lg.svg"/></div>
			</div>
		<?php } ?>
	</div>
	</div>
</body>
</html>
