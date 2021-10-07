
<?php
include ('../config_db.php');
include ('config.php');

$data=table_single_query('categorie_IFRA','Cate_IFRA ',$_POST['arguments'],$bdd);
if($data){
    echo json_encode($data);
}else{
    echo false;
}


?>