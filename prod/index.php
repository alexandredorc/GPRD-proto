<?php
session_start();
include('../config_db.php');
if (!isset($_SESSION['name'])){
	header('Location: ../login/logout.php');
}

 if(isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] > 1800) { 
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
		<title>Produits Finis</title>
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

			if(isset($_POST['code_prod']) && $_POST['code_prod']!=""){
				$_SESSION['id_prod']=table_single_nsearch('produits','Code_RD',$_POST['code_prod'],$bdd);
			}elseif (isset($_POST['id_prod']) && $_POST['id_prod']!=""){   
				$_SESSION['id_prod']=(int)$_POST['id_prod'];
			}
			
			//page de la gestion de la recherche des produits
			if(isset($_GET['recherche'])){
				include ('result_search.php');
			}
			elseif(isset($_GET['modif'])){
				
				include ('page_modif.php');
			}
			else{?>
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link <?php echo (empty($_GET))?"active":"";?> " aria-current="page" href="index.php">Info général</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['form']))?"active":"";?> <?php echo (!isset($_SESSION['id_prod']) || $_SESSION['id_prod']=="")?"disabled":"";?>" href="index.php?form=true">Formules</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['notif_prod']))?"active":"";?> <?php echo (!isset($_SESSION['id_prod']) || $_SESSION['id_prod']=="")?"disabled":"";?>" href="index.php?notif_prod=true">Catégories notif produits</a>
				</li>
			</ul>
			
			
			
					<?php
						if(empty($_GET)){?>
							<div class="body-center" style="overflow-y:auto;max-height: 90%;" >	<?php
							include('produits.php');?>
							</div>	<?php
						}
						else{
							include('prod_short.php');?>
							<div class="panel-group body-center" style="overflow-y:auto;max-height: 65%;" >	<?php
							if(isset($_GET['notif_prod'])){
								include('notif_prod.php');
							}
							elseif(isset($_GET['form'])){
								include('formules.php');
							}?>
							</div><?php
						}
					?>
			
			<?php } ?>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
	</body>
</html>
