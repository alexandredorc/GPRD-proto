<?php 
//print_r($_SESSION);



?>
<h2>Produits finis</h2>
<form action="index.php?modif=add_prod" method="POST"  style="display:flex;flex-direction:column; margin:20px;">
    <button class="btn btn-success"><i class="bi bi-plus-lg" ></i> Ajouter</button>
</form>
<h4>recherche rapide</h4>
<form action="index.php?recherche=quick_prod"  method="POST">
    <div class="input-group mb-3" style="padding:0 25% 0 0">
        <input type="text" class="form-control" name="Code_RD" aria-label="Recipient's username" aria-describedby="basic-addon2">
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
        <form action="index.php?modif=produit" method="POST" style="display:flex;flex-direction:column;">
       
            Code R&D: 
            <input type="text" readonly name="mod_prod" value= "<?php echo $data['Code_RD_prod'];?>"> </br>
            Nom R&D: 
            <input type="text" readonly value= "<?php echo $data['Nom_RD'];?>"> </br>
            Gamme R&D: 
            <input type="text" readonly value= "<?php echo $data['Gamme_RD'];?>"> </br>
            Ligne R&D: 
            <input type="text" readonly value= "<?php echo $data['Ligne_RD'];?>"> </br>
            Catégorie de produit: 
            <input type="text" readonly value= "<?php echo $data['Cat_prod'];?>"> </br>
            Catégorie IFRA: 
            <input type="text" readonly value= "<?php echo $data['Cat_IFRA_prod'];?>"> </br>

            <button class="btn btn-warning" style="margin: 50px 0">Modifier</button>
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
