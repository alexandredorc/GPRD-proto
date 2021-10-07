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
if(isset($_GET)){
    if(isset($_GET['save'])){
        $res= $bdd->query("SELECT * FROM distributeur_MP")->fetchAll();
        
        for($i=0;$i<count($res);$i++){
            $req=$bdd->prepare("UPDATE distributeur_MP SET Nom_distributeur=:Nom_distributeur WHERE index_distri=:index_distri");
            $req->execute([
            'Nom_distributeur'=> $_POST["Nom_distributeur_$i"],
            'index_distri' => $_POST["index_distri_$i"]
        ]);
        }
    }elseif(isset($_GET['add'])){
        $req=$bdd->exec("INSERT INTO distributeur_MP (Nom_distributeur) VALUES('')");
    }elseif(isset($_GET['trash'])){
        $req=$bdd->prepare("DELETE FROM distributeur_MP WHERE index_distri=:index_distri");
        $req->execute([
            'index_distri'=> $_GET['trash']
        ]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Formulaire Distributeurs MP</title>
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
            <div class="body-center" style="max-height: 90%;" >
    
                    <h2>Distributeurs MP</h2>
                    
                   
                   <?php
                    $res=$bdd->query("SELECT * FROM distributeur_MP ORDER BY Nom_distributeur")->fetchAll();?>

                    <form action="index.php?save=true" method="POST" >
                        <div class="btn_fixed" >
                            <button class="btn btn-success" type="submit" style="margin:20px 0px;" >
                                Enregistrer
                            </button></br>
                            <a class="btn btn-primary" type="button" style="margin:20px 4px; " href="index.php?add=true">
                                <i class="bi bi-plus-lg" ></i> Ajouter une ligne
                            </a>
                        </div>
                        
                            <table class="table" style="margin:0 50px 0 150px; width:80%; padding-bottom:50px;">
                                <thead>
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for($i=0;$i<count($res);$i++){?>
                                        <tr>
                                            <td>
                                                <input type="text" hidden name="index_distri_<?php echo $i;?>" value="<?php echo $res[$i]['index_distri'] ?>">
                                            </td>
                                            <td style="width:300px;">
                                                <input type="text" class="form-control" class="" name="Nom_distributeur_<?php echo $i;?>" value="<?php echo $res[$i]['Nom_distributeur'] ?>">
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?trash=<?php echo $res[$i]['index_distri'];?>'">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                </form>
            </div>			
		</div>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
	</body>
</html>

