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
        $res= table_many_query('comp_etiq_MP','Ref_planche',$_SESSION['ref_planche'],$bdd);
        
        for($i=0;$i<count($res);$i++){
            $req=$bdd->prepare("UPDATE comp_etiq_MP SET Code_MP_etiq=:Code_MP_etiq, Date_exp=:Date_exp WHERE index_etiq=:index_etiq");
            $req->execute([
            'Code_MP_etiq'=> $_POST["Code_MP_etiq_$i"],
            'Date_exp' => $_POST["Date_exp_$i"],
            'index_etiq'=> $_POST["index_etiq_$i"]
        ]);
        }
    }elseif(isset($_GET['add'])){
        $req=$bdd->prepare("INSERT INTO comp_etiq_MP 
        (Ref_planche)
        VALUES(:Ref_planche)");
        $req->execute([
            'Ref_planche'=> $_SESSION['ref_planche']
        ]);
    }elseif(isset($_GET['trash'])){
        $req=$bdd->prepare("DELETE FROM comp_etiq_MP WHERE index_etiq=:index_etiq");
        $req->execute([
            'index_etiq'=> $_GET['trash']
        ]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Edition étiquettes</title>
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
            <div class="body-center" style="overflow-y:auto;max-height: 90%;" >
                <?php 
                
                if(isset($_POST['ref_planche'])){
                    $_SESSION['ref_planche']=$_POST['ref_planche'];
                }
                
                ?>
                    <h2>Etiquettes MP</h2>
                    
                    <div style="margin-left:100px;margin-bottom:10px;">
                        <h4>
                            Référence de la planche
                        </h4>
                        <form action="index.php" method="POST">
                            <input class="form-control" style="width:70px;" name="ref_planche" type="text" value="<?php echo (isset($_SESSION['ref_planche']))?$_SESSION['ref_planche']:""; ?>">
                        </form>
                       
                    </div>
                    <?php
                    if(isset($_SESSION['ref_planche'])){
                    $res=$bdd->query("select * from comp_etiq_MP where Ref_planche='".$_SESSION['ref_planche']."'");
                    $res=$res->fetchAll();?>

                    <form action="index.php?save=true" method="POST">
                        <table class="table" style="margin:0 50px; width:calc(100% - 100px)">
                            <thead>
                                <tr>
                                    <th>Code MP</th>
                                    <th>Nom commercial MP</th>
                                    <th>N° de lot</th>
                                    <th>Exp le</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for($i=0;$i<count($res);$i++){
                                    $nom=$bdd->query("select Nom_com_MP from matieres_premieres where Code_MP='".$res[$i]['Code_MP_etiq']."'");
                                    $nom=$nom->fetch();?>
                                    <tr>
                                        <td style="width:110px;">
                                            <input type="text" class="form-control MP" name="Code_MP_etiq_<?php echo $i;?>" class="MP" value="<?php echo $res[$i]['Code_MP_etiq'] ?>">
                                        </td>
                                        <td style="width:calc(100% - 330px);">
                                            <input type="text" class="form-control" readonly value="<?php echo ($nom)?$nom['Nom_com_MP']:"" ?>">
                                        </td>
                                        <td style="width:110px;">
                                            <input type="text" class="form-control" name="index_etiq_<?php echo $i;?>" value="<?php echo $res[$i]['index_etiq'] ?>">
                                        </td>
                                        <td style="width:110px;">
                                            <input type="date" name="Date_exp_<?php echo $i;?>" value="<?php echo $res[$i]['Date_exp'] ?>">
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?trash=<?php echo $res[$i]['index_etiq'];?>'">
                                                <i class="bi bi-x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div style="margin:0 0 0 50px;">
                        <button class="btn btn-success" type="submit" style="margin:20px 0px;">
                        Enregistrer
                        </button>
                        <button class="btn btn-primary" type="button" style="margin:20px 4px;" onclick="location.href = 'index.php?add=true'">
                        <i class="bi bi-plus-lg" ></i> Ajouter une ligne
                        </button>
                        </div>
                    </form>
                    
                <?php } ?>
                
            </div>			
		</div>
		<div class="foot">
			<a href="../login/logout.php">déconnexion</a>
		</div>
	</body>
</html>
<script>
    $(".MP").on('input',function() {
        var doc=this;

        doc=doc.parentNode.parentNode.children
        $.ajax({
            type: "POST",
            url: "func_update.php",
            data: {arguments: this.value },
            dataType: 'json' 
        }).done(function(response){
            doc[1].children[0].value=response['Nom_com_MP'];
        });
       
        
    });
</script>
