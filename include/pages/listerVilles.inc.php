<h1>Liste des villes</h1>
<?php
$pdo = new Mypdo();
$villeManager = new VilleManager($pdo);
$nbrVilles = $villeManager->getNbrVilles();
echo "Actuellement " . $nbrVilles . " villes sont enregistrées";
?>
<table>
    <tr>
        <th>Numéro</th>
        <th>Nom</th>
    </tr>
    <?php
    foreach ($villeManager->getAllVilles() as $ville) { ?>
        <tr>
            <td><?php echo $ville->getVilNum(); ?></td>
            <td><?php echo $ville->getVilNom(); ?></td>
        </tr>
        <?php
    }
    ?>
</table>
