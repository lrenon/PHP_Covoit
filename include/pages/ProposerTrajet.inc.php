<?php
$pdo = new Mypdo();
$parcoursManager = new ParcoursManager($pdo);
$proposeManager = new ProposeManager($pdo);
$villeManager = new VilleManager($pdo);
?>

    <h1>Proposer un trajet</h1>

<?php
if (empty($_POST["vil_num1"])) {
    ?>
    <form action="index.php?page=9" method="post" id="vilDepart">
        <label for="vil_num1">Ville de départ :
            <select name="vil_num1" id="vil_num1">
                <option value="null">Choisissez</option>
                <?php
                foreach ($parcoursManager->getAllVilles() as $ville) {
                    ?>
                    <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                    <?php
                }
                ?>
            </select>
        </label>
        <input type="submit" name="submit" value="Valider">
    </form>
    <?php
}

if (!empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["pro_date"]) && empty($_POST["pro_time"]) && empty($_POST["pro_place"])) {
    $_SESSION["vil_num1"] = $_POST["vil_num1"];
    ?>
    <form action="index.php?page=9" method="post" id="proposerTrajet">
        <label>Ville de départ : <?php echo $villeManager->getVilNom($_SESSION["vil_num1"]) ?></label>
        <label for="vil_num2">Ville d'arrivée :
            <select name="vil_num2" id="vil_num2">
                <?php
                foreach ($parcoursManager->getAllArrivees($_SESSION["vil_num1"]) as $ville) {
                    ?>
                    <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                    <?php
                }
                ?>
            </select>
        </label>
        <label for="pro_date">Date de départ : <input type="date" name="pro_date" id="pro_date"
                                                      value="<?php echo date('Y-m-d'); ?>"></label>
        <label for="pro_time">Heure de départ : <input type="time" name="pro_time" id="pro_time"
                                                       value="<?php echo date("H:i:s"); ?>"></label>
        <label for="pro_place">Nombre de places : <input type="text" name="pro_place" id="pro_place"></label>
        <input type="submit" name="submit" value="Valider">
    </form>
    <?php
}

if (empty($_POST["vil_num1"]) && !empty($_POST["vil_num2"]) && !empty($_POST["pro_date"]) && !empty($_POST["pro_time"]) && !empty($_POST["pro_place"])) {
    $post = array(
        'par_num' => $parcoursManager->getParcours($_SESSION["vil_num1"], $_POST["vil_num2"]),
        'per_num' => $_SESSION["per_num"],
        'pro_date' => $_POST["pro_date"],
        'pro_time' => $_POST["pro_time"],
        'pro_place' => $_POST["pro_place"],
        'pro_sens' => $proposeManager->getProSens($_SESSION["vil_num1"], $_POST["vil_num2"]));

    $trajet = new Propose($post);
    $retour = $proposeManager->ajouterTrajet($trajet);

    if ($retour != 0) {
        ?>
        <img src="image/valid.png" alt="valid">
        <?php
        echo "Le trajet a été ajouté !";
    } else {
        ?>
        <img src="image/erreur.png" alt="erreur">
        <?php
        echo "Le trajet n'a pas pu être ajouté !";
    }
}