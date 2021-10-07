
<div class="body-center" style="max-width:none;">
    
    <h1>Ajouter une Matières Premières</h1>
    <form action="index.php?MP=push" method="POST" style="display:flex;flex-direction:column;">
        <table>
            <tr>
                <th>Code MP 
                    <input type="text" name="Code_MP" class="form-control" >
                </th>
                <th>Nom commercial de la MP 
                    <input type="text" name="Nom_com_MP" class="form-control" >
                </th>
                <th>Dénomination INCI 
                    <input type="text" name="Nom_MP" class="form-control" >
                </th>
            </tr>
        </table>
        <div>
        <button class="btn btn-success">
            <strong>Ajouter</strong>
        </button>
        <?php if(isset($_GET['erreur'])){
            ?>
            <div class="erreur">
                la réference qui à été renseigné existe déjà
            </div>
        <?php } ?>
        </form>

        </div>
        
    </form>
</div>
