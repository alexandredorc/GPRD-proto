<?php 
//print_r($_SESSION);



?>
<h2>Produits finis</h2>
<form action="index.php?modif=add_prod" method="POST"  style="display:flex;flex-direction:column; margin:20px;">
    <button class="btn btn-success"style="width:100px;"><strong><i class="bi bi-plus-lg" ></i> Ajouter</strong></button>
</form>
<h4>recherche rapide</h4>
<form action="index.php?recherche=quick_prod"  method="POST">
    <div class="input-group mb-3" style="padding:0 25% 0 0; ">
        <input type="text" class="form-control" name="Code_RD" style="width:200px;">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
        </div>
    </div>

</form>



<form action="index.php" method="POST">
    <div class="input-group " style="display:flex;">
        <div class="input-group-prepend">
            <button type="submit" class="btn btn-primary">Envoyé</button>
            <button class="btn btn-outline-secondary" onclick="prev_product()"> < </button>
        </div>
        <input name="id_prod" class="form-control" id="id_prod" style="min-width:50px;" type="number" min="1" value="<?php echo (isset($_SESSION['id_prod']))?$_SESSION['id_prod']:"";?>" >
        <div class="input-group-append">
            <button  class="btn btn-outline-secondary" onclick="next_product()"> > </button>
        </div>
        
    </div>
</form>

<?php   
    

    if(isset($_SESSION['id_prod']))  {  
        $data=table_single_nquery('produits',$_SESSION['id_prod'],$bdd);
        if($data){
            //
            ?>
        <form action="index.php?modif=produit" method="POST" style="display:flex;flex-direction:column; width:70%;padding:50px;">
            <table class="table" >
                <colgroup>
                    <col span="1" style="width: 15%;">
                    <col span="1" style="width: 70%;">
                </colgroup>
                <tr style="text-align:left;">
                    <td>Code R&D: </td>
                    <td><h5><?php echo $data['Code_RD_prod'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Nom R&D: </td>
                    <td><h5><?php echo $data['Nom_RD'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Gamme R&D: </td>
                    <td><h5><?php echo $data['Gamme_RD'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Ligne R&D: </td>
                    <td><h5><?php echo $data['Ligne_RD'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Catégorie de produit: </td>
                    <td><h5><?php echo $data['Cat_prod'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Catégorie IFRA: </td>
                    <td><h5><?php echo $data['Cat_IFRA_prod'];?></h5></td>
                </tr>
            </table>
            <button class="btn btn-warning" style="width:100px;"><strong>Modifier</strong></button>
        </form>
        
        
<?php   
        } 
    }
?>


<script>
    function next_product() {
        document.getElementById("id_prod").stepUp();
    }
    function prev_product(){
        document.getElementById("id_prod").stepDown();
    }
</script>
