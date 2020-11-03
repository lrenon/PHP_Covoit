<h1>Ajouter un parcours</h1>
<?php
$pdo = new Mypdo();

if (empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["par_km"])) {
    $villeManager = new VilleManager($pdo);
    $villes = $villeManager->getAllVilles();
    ?>
    <form action="index.php?page=5" method="post">
        <label for="vil_num1">Ville 1 :</label>
        <select name="vil_num1" id="vil_num1">
            <?php
            foreach ($villes as $ville) {
                ?>
                <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php
            }
            ?>
        </select>
        <label for="vil_num2">Ville 2 :</label>
        <select name="vil_num2" id="vil_num2">
            <?php
            foreach ($villes as $ville) {
                ?>
                <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php
            }
            ?>
        </select>
        <label for="par_km">Nombre de kilomètre(s)</label>
        <input type="text" name="par_km" id="par_km">
        <input type="submit" value="Valider">
    </form>
    <?php
} else {
    $parcoursManager = new ParcoursManager($pdo);
    $parcours = new Parcours($_POST);
    $retour = $parcoursManager->ajouterParcours($parcours);

    if ($retour != 0) {
        ?>
        <img src="image/valid.png" alt="valid">
        <?php
        echo "Le parcours a été ajouté";
    }
}