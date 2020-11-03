<h1>Liste des parcours proposés</h1>
<?php
$pdo = new Mypdo();
$parcoursManager = new ParcoursManager($pdo);
$villeManager = new VilleManager($pdo);
$nbrParcours = $parcoursManager->getNbrParcours();
echo "Actuellement " . $nbrParcours . " parcours sont enregistrés";
?>
<table>
    <tr>
        <th>Numéro</th>
        <th>Nom ville</th>
        <th>Nom ville</th>
        <th>Nom de Km</th>
    </tr>
    <?php
    foreach ($parcoursManager->getAllParcours() as $parcours) { ?>
        <tr>
            <td><?php echo $parcours->getParNum(); ?></td>
            <td><?php echo $villeManager->getVilNom($parcours->getVilNum1()); ?></td>
            <td><?php echo $villeManager->getVilNom($parcours->getVilNum2()); ?></td>
            <td><?php echo $parcours->getParKm(); ?></td>
        </tr>
        <?php
    }
    ?>
</table>