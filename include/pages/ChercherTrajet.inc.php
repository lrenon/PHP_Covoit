<?php
$pdo = new Mypdo();
$parcoursManager = new ParcoursManager($pdo);
$proposeManager = new ProposeManager($pdo);
$villeManager = new VilleManager($pdo);
?>

    <h1>Rechercher un trajet</h1>

<?php
if (empty($_POST["vil_num1"])) {
    ?>
    <form action="index.php?page=10" method="post">
        <label for="vil_num1">Ville de départ : </label>
        <select name="vil_num1" id="vil_num1">
            <option value="null">Choisissez</option>
            <?php
            foreach ($proposeManager->getAllDeparts() as $ville) {
                ?>
                <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
                <?php
            }
            ?>
        </select>
        <input type="submit" name="submit" value="Valider">
    </form>
    <?php
}

if (!empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["pro_date"]) && empty($_POST["pro_time"]) && empty($_POST["precision"])) {
    $_SESSION["vil_num1"] = $_POST["vil_num1"];
    ?>
    <form action="index.php?page=10" method="post" id="chercherTrajet">
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
        <label for="precision">Précision :
            <select name="precision" id="precision">
                <option value="0">Ce jour</option>
                <option value="1">+/- 1 jour</option>
                <option value="2">+/- 2 jours</option>
                <option value="3">+/- 3 jours</option>
            </select>
        </label>
        <label for="pro_time">A partir de :
            <select name="pro_time" id="pro_time">
                <?php
                for ($heure = 0; $heure < 24; $heure++) {
                    ?>
                    <option value="<?php echo $heure ?>"><?php echo $heure . "h" ?></option>
                    <?php
                }
                ?>
            </select>
        </label>
        <input type="submit" name="submit" value="Valider">
    </form>
    <?php
}

if (empty($_POST["vil_num1"]) && !empty($_POST["vil_num2"]) && !empty($_POST["pro_date"]) && !empty($_POST["pro_time"]) && !empty($_POST["precision"])) {
    $trajets = $proposeManager->getAllTrajets($_SESSION["vil_num1"], $_POST["vil_num2"], $_POST["pro_date"] - $_POST["precision"], $_POST["pro_date"] + $_POST["precision"], $_POST["pro_time"]);
    print_r($trajets);
}