<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
$nbrPersonnes = $personneManager->getNbrPersonnes();
if (empty($_GET["per_num"])) {
    ?>
    <h1>Liste des personnes enregistrées</h1>
    <?php
    echo "Actuellement " . $nbrPersonnes . " personnes sont enregistrées";
    ?>
    <table>
    <tr>
        <th>Numéro</th>
        <th>Nom</th>
        <th>Prénom</th>
    </tr>
    <?php
    foreach ($personneManager->getAllPersonnes() as $personne) { ?>
        <tr>
            <td><a href="index.php?page=2&per_num=<?php echo $personne->getPerNum() ?>"><?php echo $personne->getPerNum() ?></a></td>
            <td><?php echo $personne->getPerNom() ?></td>
            <td><?php echo $personne->getPerPrenom() ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<?php
} else {
    $per_num = $_GET["per_num"];
    $personne = $personneManager->getPersonne($per_num);
    if ($personneManager->estUnEtudiant($per_num)) {
        $etudiantManager = new EtudiantManager($pdo);
        $etudiant = $etudiantManager->getEtudiant($per_num);
        $departementManager = new DepartementManager($pdo);
        $villeManager = new VilleManager($pdo);
        ?>
        <h1>Détails sur l'étudiant <?php echo $personne->getPerNom() ?></h1>
        <table>
            <tr>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Tel</th>
                <th>Departement</th>
                <th>Ville</th>
            </tr>
            <tr>
                <td><?php echo $personne->getPerPrenom() ?></td>
                <td><?php echo $personne->getPerMail() ?></td>
                <td><?php echo $personne->getPerTel() ?></td>
                <td><?php echo $departementManager->getDepartement($etudiant->getDepNum())->getDepNom() ?></td>
                <td><?php echo $villeManager->getVilNom($departementManager->getDepartement($etudiant->getDepNum())->getVilNum()) ?></td>
            </tr>
        </table>
        <?php
    } else {
        $salarieManager = new SalarieManager($pdo);
        $salarie = $salarieManager->getSalarie($per_num);
        $fonctionManager = new FonctionManager($pdo);
        ?>
        <h1>Détails sur le salarié <?php echo $personne->getPerNom() ?></h1>
        <table>
            <tr>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Tel</th>
                <th>Tel pro</th>
                <th>Fonction</th>
            </tr>
            <tr>
                <td><?php echo $personne->getPerPrenom() ?></td>
                <td><?php echo $personne->getPerMail() ?></td>
                <td><?php echo $personne->getPerTel() ?></td>
                <td><?php echo $salarie->getSalTelprof() ?></td>
                <td><?php echo $fonctionManager->getFonction($salarie->getFonNum())->getFonLibelle() ?></td>
            </tr>
        </table>
        <?php
    }
}
?>

