<?php
$pdo = new Mypdo();
$parcoursManager = new ParcoursManager($pdo);
$proposeManager = new ProposeManager($pdo);
$villeManager = new VilleManager($pdo);
$personneManager = new PersonneManager($pdo);
?>

    <h1>Rechercher un trajet</h1>

<?php
if (empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["pro_date"]) && empty($_POST["pro_time"]) && empty($_POST["precision"])) {
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
    if ($_SESSION["vil_num1"] != 0) {
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
    } else {
        echo "Vous voulez sûrement partir de quelque part, non... ? Alors choisissez une ville de départ !";
    }
}

if (empty($_POST["vil_num1"]) && !empty($_POST["vil_num2"]) && !empty($_POST["pro_date"]) && !empty($_POST["pro_time"]) && !empty($_POST["precision"])) {
    $vilnum1 = $_SESSION["vil_num1"];
    $vilnum2 = $_POST["vil_num2"];
    $prodate = $_POST["pro_date"];
    $precision = $_POST["precision"];
    $protime = $_POST["pro_time"] . ":00:00";
    $trajets = $proposeManager->getAllTrajets($vilnum1, $vilnum2, $prodate, $precision, $protime);

    if (!empty($trajets)) {
        ?>
        <table>
            <tr>
                <th>Ville départ</th>
                <th>Ville arrivée</th>
                <th>Date départ</th>
                <th>Heure départ</th>
                <th>Nombre de place(s)</th>
                <th>Nom du covoitureur</th>
            </tr>
            <?php
            foreach ($trajets as $trajet) {
                $covoitureur = $personneManager->getPersonne($trajet->getPerNum());
                ?>
                <tr>
                    <td><?php echo $villeManager->getVilNom($vilnum1) ?></td>
                    <td><?php echo $villeManager->getVilNom($vilnum2) ?></td>
                    <td><?php echo $trajet->getProDate() ?></td>
                    <td><?php echo $trajet->getProTime() ?></td>
                    <td><?php echo $trajet->getProPlace() ?></td>
                    <td><?php echo $covoitureur->getPerNom() . " " . $covoitureur->getPerPrenom() ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "Pas de trajets disponibles à cette date...";
    }
}