

<?php
    if(isset($_GET['appel'])){
        if($_GET['appel']=="add"){
            $req=$bdd->prepare("INSERT INTO appellations 
            (Ref_form_appel)
            VALUES(:Ref_form_appel)");
        $req->execute([
            'Ref_form_appel'=> $_SESSION['ref_form']
            ]);
        }
        elseif($_GET['appel']=="save"){
            $res= table_to_table('formules','appellations','Ref_form_appel','Ref_form_appel',$_SESSION['ref_form'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                $req=$bdd->prepare("UPDATE appellations SET Nom_com=:Nom_com, Gamme_com=:Gamme_com,Ligne_com=:Ligne_com, Ref_form_appel=:Ref_form_appel WHERE Ref_appel= :Ref_appel");
                $req->execute([
                'Nom_com'=> $_POST["Nom_com_$i"],
                'Gamme_com'=> $_POST["Gamme_com_$i"],
                'Ligne_com'=> $_POST["Ligne_com_$i"],
                'Ref_form_appel'=> $_SESSION["ref_form"],
                'Ref_appel'=> $_POST["Ref_appel_$i"]
            ]);
            $_POST["Ref_appel_$i"]=NULL;
            }
        }
        elseif($_GET['appel']=="trash"){
            $req=$bdd->prepare("DELETE FROM appellations WHERE Ref_appel= :Ref_appel");
            $req->execute([
                'Ref_appel'=> $_GET['id']
            ]);
        }
    }
?>


  

    <div class="comp_form_prod">
    <?php
    if(isset($_SESSION['ref_form'])) { ?>
        <div>
            <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?appel=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter une Appellations
            </button>
        </div>
        <form action="index.php?appel=save" method="POST">
        <?php
        $res= table_to_table('formules','appellations','Ref_form_appel','Ref_form_appel',$_SESSION['ref_form'],$bdd)->fetchAll();
        if(count($res)!=0){
            ?>La formule a <?php echo count($res);?> lignes </br>
                <table class="table">
                <thead>
                    <tr>
                        <th style="width:30%;">Nom commercial</th>
                        <th class="vv-long">Ligne commercial</th>
                        <th class="vv-long">Gamme commercial</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for($i=0;$i<count($res);$i++){
                        $_SESSION['Ref_appel']=$res[$i]['Ref_appel']
                    ?>
                        <tr>
                            <td hidden><input type="text" name="Ref_appel_<?php echo $i;?>" value="<?php echo $res[$i]['Ref_appel'] ?>"> </td>
                            <td style="width:30%;"><textarea  name="Nom_com_<?php echo $i;?>" cols="100" rows="1"><?php echo $res[$i]['Nom_com'] ?></textarea></td>
                            <td class="vv-long"><input  type="text" name="Ligne_com_<?php echo $i;?>" value="<?php echo $res[$i]['Ligne_com'] ?>"></td>
                            <td class="vv-long"><input  type="text" name="Gamme_com_<?php echo $i;?>" value="<?php echo $res[$i]['Gamme_com'] ?>"></td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?appel=trash&id=<?php echo $_SESSION['Ref_appel'];?>'">
                                <i class="bi bi-x"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
            <div>
                <button class="btn btn-success" style="margin:20px 0px;">
                Enregistrer
                </button>
            </div>
            <?php } ?>
        </form>
    </div>

