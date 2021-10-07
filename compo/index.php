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
		<title>Composants</title>
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

			if(isset($_POST['nom_inci'])){
				$_SESSION['Nom_INCI']=$_POST['nom_inci'];
			}

			if(isset($_GET['code'])){
				$_SESSION['Nom_INCI']=$_GET['code'];
			}
			//page de la gestion de la recherche des produits
			if(isset($_GET['compo'])){
				include ('change_compo.php');
			}
			else{?>
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link <?php echo (empty($_GET))?"active":"";?>" aria-current="page" href="index.php">Info général</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['comp_reg']))?"active":"";?> <?php echo (!isset($_SESSION['Nom_INCI']) || $_SESSION['Nom_INCI']=="")?"disabled":"";?>" href="index.php?comp_reg=true">Réglementation du composant</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['synth_reg']))?"active":"";?> <?php echo (!isset($_SESSION['Nom_INCI']) || $_SESSION['Nom_INCI']=="")?"disabled":"";?>" href="index.php?synth_reg=true">Synthèse Réglementaire</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo (isset($_GET['notif_compo']))?"active":"";?> <?php echo (!isset($_SESSION['Nom_INCI']) || $_SESSION['Nom_INCI']=="")?"disabled":"";?>" href="index.php?notif_compo=true">Notifications Composant</a>
					</li>
				</ul>
					<?php
						if(isset($_GET['code']) || empty($_GET)){?>
							<div class="panel-group body-center" style="overflow-y:auto;max-height: 90%;" >	<?php
							include('composants.php');?>
							</div>	<?php
						}
						else{
							include('comp_short.php');?>
							<div class="panel-group body-center" style="overflow-y:auto;max-height: 65%;" >	<?php
							if( isset($_GET['comp_reg'])){
								include('reg_comp.php');
							}
							elseif(isset($_GET['synth_reg'])){
								include('synth_reg.php');
							}
							elseif(isset($_GET['notif_compo'])){
								include('notif_compo.php');
							}?>
							</div><?php
						}
					?>
			<?php } ?>
		</div>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
	</body>
</html>
