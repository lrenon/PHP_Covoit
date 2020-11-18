<?php
//var_dump($_POST);
if (empty($_POST["vil_nom"])) {
    ?>
    <h1>Ajouter une ville</h1>
    <form action="index.php?page=7" method="post">
        <label for="vilNom">Nom :</label>
        <input type="text" name="vil_nom" id="vilNom">
        <input type="submit" value="Valider">
    </form>
    <?php
} else {
    $pdo = new Mypdo();
    $villeManager = new VilleManager($pdo);
    $ville = new Ville($_POST);
    $retour = $villeManager->ajouterVille($ville);

    if ($retour != 0) {
        ?>
        <img src="image/valid.png" alt="valid">
        <?php
        echo "La ville " . $ville->getVilNom() . " a été ajoutée";
    }
}