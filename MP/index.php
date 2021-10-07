<?php
session_start();
include('../config_db.php');
if (!isset($_SESSION['name'])){
	header('Location: ../login/logout.php');
}
if(isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] > 900) { 
    session_destroy();
    header('Location: ../login/logout.php');
} else {
    $_SESSION['timestamp'] = time(); //set new timestamp
}
setcookie('auto_login',$_SESSION['user_id'],time()+60, '/', null, false, true);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Page d'accueil</title>
		<link rel="stylesheet" href="../public/styles_prod.css">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="head">
			<div class="logo">
				<img src="../public/logo_ASEPTA.png">
			</div>
			<div class="menu">
				<?php
					include('../menu.html');
				?>
			</div>
			
		</div>

		<div class="body" >
			<?php 
			include ('config.php');
			if(isset($_POST['codeMP']) ){
				$_SESSION['Code_MP']=$_POST['codeMP'];
			}

			if(isset($_GET['code'])){
				$_SESSION['Code_MP']=$_GET['code'];
			}
			//page de la gestion de la recherche des produits
			if(isset($_GET['MP'])){
				include ('change_MP.php');
			}
			else{?>
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link <?php echo (empty($_GET))?"active":"";?>" aria-current="page" href="index.php">Info général</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['distri']))?"active":"";?> <?php echo (!isset($_SESSION['Code_MP']) || $_SESSION['Code_MP']=="")?"disabled":"";?>" href="index.php?distri=true">Distributeurs MP</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['MP_comp']))?"active":"";?> <?php echo (!isset($_SESSION['Code_MP']) || $_SESSION['Code_MP']=="")?"disabled":"";?>" href="index.php?MP_comp=true">Composition MP en Nom INCI</a>
					</li>
					<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['allerg']))?"active":"";?> <?php echo (!isset($_SESSION['Code_MP']) || $_SESSION['Code_MP']=="")?"disabled":"";?>" href="index.php?allerg=true">Composition MP en allergènes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['reg_IFRA']))?"active":"";?> <?php echo (!isset($_SESSION['Code_MP']) || $_SESSION['Code_MP']=="")?"disabled":"";?>" href="index.php?reg_IFRA=true">Réglementation IFRA</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['synth']))?"active":"";?> <?php echo (!isset($_SESSION['Code_MP']) || $_SESSION['Code_MP']=="")?"disabled":"";?>" href="index.php?synth=true">Synthèse Réglementaire</a>
					</li>
				</ul>
				
				<?php
					if(isset($_GET['code']) || empty($_GET)){?>
						<div class="body-center" style="overflow-y:auto;max-height: 90%;" >	<?php
							include('matiere_prem.php');?>
						</div>	<?php
					}
					else{
						include('MP_short.php');//calc(95% - 200px);
						?>
						<div class="body-center" style="overflow-y:auto;max-height:calc(95% - 200px); " >	<?php
							
							if(isset($_GET['distri'])){
								include('distributeur.php');
							}
							elseif(isset($_GET['MP_comp'])){
								include('comp_INCI.php');
							}
							elseif(isset($_GET['allerg'])){
								include('comp_aller.php');
							}
							elseif(isset($_GET['reg_IFRA'])){
								include('reg_IFRA.php');
							}
							elseif(isset($_GET['synth'])){
								include('reg_synth.php');
							}?>
						</div>	<?php
					} } ?>
			
		</div>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
	</body>
</html>
