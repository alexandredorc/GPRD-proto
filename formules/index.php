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



include('config.php');
if (isset($_POST['ref_form'])){
    $_SESSION['ref_form']=$_POST['ref_form'];
}
if(isset($_SESSION['ref_form'])){
	$res=$bdd->query("select * from formules where Ref_form='".$_SESSION['ref_form']."'");
	$res=$res->fetch();
	if($res){
	$_SESSION['id_prod']=table_single_nsearch('produits','Code_RD_prod',$res['Code_RD'],$bdd);
}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Page d'accueil</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../public/styles_prod.css">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		
        
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
			//page de la gestion de la recherche des produits
			if(isset($_GET['recherche'])){
				include ('result_search.php');
			}
			elseif(isset($_GET['modif'])){
				include ('page_modif.php');
			}else{?>
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link <?php echo (empty($_GET))?"active":"";?>" aria-current="page" href="index.php">Info général</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['appel']))?"active":"";?> <?php echo (!isset($_SESSION['ref_form']) || $_SESSION['ref_form']=="")?"disabled":"";?>" href="index.php?appel=true">Appellations commerciales</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['comp_form']))?"active":"";?> <?php echo (!isset($_SESSION['ref_form']) || $_SESSION['ref_form']=="")?"disabled":"";?>" href="index.php?comp_form=true">Composition Formule</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['notif']))?"active":"";?> <?php echo (!isset($_SESSION['ref_form']) || $_SESSION['ref_form']=="")?"disabled":"";?>" href="index.php?notif=true">Notifications</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo (isset($_GET['ajust']))?"active":"";?> <?php echo (!isset($_SESSION['ref_form']) || $_SESSION['ref_form']=="")?"disabled":"";?>" href="index.php?ajust=true">Ajustement Industriel</a>
				</li>
			</ul>
			
					<?php
						if(empty($_GET)){?>
							<div class="body-center" style="overflow-y:auto;max-height: 90%;" >	<?php
							include('formules.php');?>
							</div>	<?php
							
						}
						else{
							include('form_short.php');?>
							<div class="body-center" style="overflow-y:auto;max-height: 65%;" >	<?php
								if(isset($_GET['appel'])){
									include('appel_form.php');
								}
								elseif(isset($_GET['comp_form'])){
									include('comp_form.php');
								}
								elseif(isset($_GET['notif'])){
									include('notification.php');
								}
								elseif(isset($_GET['ajust'])){
									include('ajust_indus.php');
								}?>
							</div><?php
						}
					?>
		
		</div>
		<?php }?>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
	</body>
</html>
