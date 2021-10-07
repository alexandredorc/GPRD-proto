<?php
/*
*
*
//////// PRODUITS FINIS ////////
*
*
*
*/
//Access à la page de modification produits
if($_GET['modif']=='produit'){
    include('modif_prod.php');
}

//Access à la page de ajout produits

elseif($_GET['modif']=='add_prod'){
    include('add_prod.php');
}

//Inserer une nouvelle formule

elseif($_GET['modif']=='push_prod'){
    $data=$bdd->query("SELECT Code_RD_prod FROM produits WHERE Code_RD_prod='".$_POST['Code_RD_prod']."'");
    $data=$data->fetchAll();
    if(count($data)!=0){
        header('Location: index.php?modif=add_prod&erreur=1');
        
    }else{
        $req=$bdd->prepare("INSERT INTO `produits` 
        ( Nom_RD, Code_RD_prod) 
        VALUES (:Nom_RD , :Code_RD)");
        $req->execute([
            'Nom_RD' => $_POST['Nom_RD'],
            'Code_RD' => $_POST['Code_RD_prod'], 
            ]);
        $_SESSION['mod_prod']=$_POST['Code_RD_prod'];
        header('Location: index.php?modif=produit&main=true');
    }
}

//Appliquer les changements d'un produit

elseif($_GET['modif']=='change_prod'){
    if($_POST['btn']=='change'){
        $req=$bdd->prepare("UPDATE produits SET 
        Gamme_RD= :Gamme_RD , 
        Ligne_RD= :Ligne_RD , 
        Nom_RD= :Nom_RD , 
        Code_RD_prod= :Code_RD_prod , 
        Cat_prod= :Cat_prod , 
        Cat_IFRA_prod= :Cat_IFRA_prod WHERE Code_RD_prod= :Code ");
    
        $req->execute(array(
        'Gamme_RD' => $_POST['Gamme_RD'],
        'Ligne_RD' => $_POST['Ligne_RD'],
        'Nom_RD' => $_POST['Nom_RD'],
        'Code_RD_prod' => $_POST['Code_RD_prod'],
        'Cat_prod' => $_POST['Cat_prod'],
        'Cat_IFRA_prod' => $_POST['Cat_IFRA_prod'],
        'Code' => $_SESSION['mod_prod']
    ));

        $_SESSION['id_prod']=table_single_nsearch('produits','Code_RD_prod',$_POST['Code_RD_prod'],$bdd);
    }
    elseif($_POST['btn']="suppr"){
        $data=$_SESSION['mod_prod'];
        $sql="DELETE FROM comp_form WHERE id_comp IN (SELECT * FROM(SELECT id_comp FROM formules JOIN comp_form ON Ref_form_RD =Ref_form WHERE Code_RD='$data') AS alias )";
        $req=$bdd->exec($sql);
        $req=$bdd->exec("DELETE FROM formules WHERE Code_RD='$data'");
        $req=$bdd->exec("DELETE FROM produits WHERE Code_RD_prod='$data'");
        
    }
    header('Location: index.php');
}
