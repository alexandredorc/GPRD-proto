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


if(!isset($_GET['url'])){?>
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Fiches de consultation</title>
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
			<div class="body-center">
                <div class="list-H">
                    <h3>
                        Liste des états pour les produits
                    </h3>
                    <form action="index.php" style="margin:30px; width:30%;" method="GET">
                        <h4>recherche rapide</h4>
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" style="min-width:50px;">
                            <button class="btn btn-outline-secondary" ><i class="bi bi-search"></i></button></br>
                        </div>
                    </form>
                </div>
                <div class="list-B">
                    <?php
					include('config.php');
                        $data=table_many_query('etats',array(array('Titre',(isset($_GET['search']))?$_GET['search']:'')),$bdd);
						if($data){
						for($i=0;$i<count($data);$i++){
							?>
							<div style="margin:5px;">
							<button class="btn btn-outline-secondary" style="border: grey solid 1px;" onclick="location.href = 'index.php?url=<?php echo $data[$i]['URL']?>'">
								<?php
									echo $data[$i]['Titre']
								?>
							</button>
							</div>
							<?php
						}}
                    ?>
                </div>
            </div>
		</div>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
		
	</body>
</html>
<?php }
	else{
		include($_GET['url']);
	}
?>