
<?php 
session_start();

include('../config_db.php');
include('config.php');
if(isset($_GET['add'])){
    if($_GET['add']!=-1){
        $data=table_single_query('comp_form','id_comp',$_GET['add'],$bdd);
        $bdd->exec("UPDATE comp_form SET Ligne = Ligne+1
        WHERE Ligne>= ".$data['Ligne']." AND  Ref_form_RD = '".$data['Ref_form_RD']."'");
        $bdd->exec("INSERT INTO comp_form( Ref_form_RD, Phase, Ligne, Code_MP, `%_MP_form`, `%_MP_mini`, `%_MP_maxi`) 
        VALUES ('".$data['Ref_form_RD']."','".$data['Phase']."','".$data['Ligne'] ."','','','','')");
    }else{
        $size=table_size("comp_form",array(array("Ref_form_RD",$_SESSION['ref_form'])),$bdd);
        if($size){
            $data=table_many_query("comp_form",array(array("Ref_form_RD",$_SESSION['ref_form']),array('Ligne',$size)),$bdd);
            $sql="INSERT INTO comp_form(Ref_form_RD, Phase, Ligne, Code_MP, `%_MP_form`, `%_MP_mini`, `%_MP_maxi`) 
            VALUES ('".$data['Ref_form_RD']."','".($data['Phase'])."','".($data['Ligne']+1)."','','','','')";
        }else{
            $sql="INSERT INTO comp_form( Ref_form_RD, Phase, Ligne, Code_MP, `%_MP_form`, `%_MP_mini`, `%_MP_maxi`) 
            VALUES ('".$_SESSION['ref_form']."','',1,'','','','')";
        }
        $bdd->exec($sql);
    }
}if(isset($_GET['trash'])){
    $data=table_single_query('comp_form','id_comp',$_GET['trash'],$bdd);
    if($data){
        $bdd->exec("UPDATE comp_form SET Ligne = Ligne-1 WHERE Ligne>= ".$data['Ligne']." AND  Ref_form_RD = '".$data['Ref_form_RD']."'");
        $bdd->exec("DELETE FROM comp_form WHERE id_comp=".$_GET['trash']);
    }
}
if(isset($_GET['up'])){
    $data=table_single_query('comp_form','id_comp',$_GET['up'],$bdd);
    if($data && $data['Ligne']>1){
        $cond=array(array('Ligne',($data['Ligne']-1)),array('Ref_form_RD',$data['Ref_form_RD']));
        $other_data=table_many_query('comp_form',$cond,$bdd);
        $bdd->exec("UPDATE comp_form SET Ligne = Ligne-1 WHERE id_comp='".$data['id_comp']."'");
        $bdd->exec("UPDATE comp_form SET Ligne = Ligne+1 WHERE id_comp='".$other_data['id_comp']."'");
    }
}
if(isset($_GET['down'])){
    $data=table_single_query('comp_form','id_comp',$_GET['down'],$bdd);
    $size=table_size('comp_form',array(array('Ref_form_RD',$data['Ref_form_RD'])),$bdd);
    if($data && $data['Ligne']<$size){
        $cond=array(array('Ligne',($data['Ligne']+1)),array('Ref_form_RD',$data['Ref_form_RD']));
        $other_data=table_many_query('comp_form',$cond,$bdd);
        $bdd->exec("UPDATE comp_form SET Ligne = Ligne+1 WHERE id_comp='".$data['id_comp']."'");
        $bdd->exec("UPDATE comp_form SET Ligne = Ligne-1 WHERE id_comp='".$other_data['id_comp']."'");
    }
}
if(isset($_GET['clean'])){
    $res=$res= table_to_table('formules','comp_form','Ref_form_RD','Ref_form_RD',$_SESSION['ref_form'],$bdd," ORDER BY Ligne ASC ")->fetchAll();
    $size=count($res);
    $req=$bdd->prepare("UPDATE comp_form SET Phase='' WHERE id_comp= :id_comp ");
    for($i=0;$i<$size;$i++){
        $req->execute([
            'id_comp'=> ($res[$i]['id_comp'])
        ]);
    }
}
//permet d'enregistrer les données du tableau dans la basse de donnée, 
//il permet de faire permuter les lignes à l'aide de la zone input
if(isset($_GET['save'])){
    $res=$res= table_to_table('formules','comp_form','Ref_form_RD','Ref_form_RD',$_SESSION['ref_form'],$bdd," ORDER BY Ligne ASC ")->fetchAll();
    $size=count($res);
    $id=table_single_query('comp_form','Ref_form_RD',$_SESSION['ref_form'],$bdd);
    for($i=0;$i<$size;$i++){
        $tab_L[]= array('id'=>$i,'ligne'=>($_POST["Ligne_$i"]==($i+1))?($_POST["Ligne_$i"]."z"):$_POST["Ligne_$i"]);
    }
    $columns = array_column($tab_L, 'ligne');
    array_multisort($columns, SORT_NATURAL, $tab_L);
    $req=$bdd->prepare("UPDATE comp_form SET Phase=:Phase ,Ligne= :Ligne, Code_MP= :Code_MP ,`%_MP_form`= :MP_form WHERE id_comp= :id_comp ");
    for($i=0;$i<$size;$i++){
        $id=$tab_L[$i]['id'];
        str_replace("%", "", $_POST["%_MP_form_$id"]);
        $req->execute([
        'Phase' => $_POST["Phase_$id"],
        'Ligne'=> $i+1,
        'Code_MP'=> $_POST["Code_MP_$id"],
        'MP_form'=> doubleval($_POST["%_MP_form_$id"]),
        'id_comp'=> ($res[$id]['id_comp'])
    ]);
    }
}
header('Location: index.php?comp_form=true');
?>


