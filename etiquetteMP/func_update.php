<?php

include ('config.php');

$data=table_single_query('matieres_premieres','Code_MP',$_POST['arguments'],$bdd);
if($data){
    echo json_encode($data);
}else{
    echo false;
}


?>