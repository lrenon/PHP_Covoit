<?php
$pdo = new Mypdo();

if (empty($_POST["per_nom"]) && empty($_POST["per_prenom"]) && empty($_POST["per_tel"]) && empty($_POST["per_mail"]) && empty($_POST["per_login"]) && empty($_POST["per_pwd"])) {
    if (!empty($_POST["div_num"]) && !empty($_POST["dep_num"])) {
        $personneManager = new PersonneManager($pdo);
        $personne = unserialize($_SESSION["personne"]);
        $num_pers_ajoutee = $personneManager->ajouterPersonne($personne);

        if ($num_pers_ajoutee != 0) {
            ?>
            <img src="image/valid.png" alt="valid">
            <?php
            echo "La personne a été ajoutée !";
        }

        $etudiantManager = new EtudiantManager($pdo);
        $etudiant = new Etudiant($_POST);
        $retour = $etudiantManager->ajouterEtudiant($etudiant, $num_pers_ajoutee);

        if ($retour != 0) {
            ?>
            <img src="image/valid.png" alt="valid">
            <?php
            echo "L'étudiant a été ajouté !";
        }
    }
    if (!empty($_POST["sal_telprof"]) && !empty($_POST["fon_num"])) {
        $personneManager = new PersonneManager($pdo);
        $personne = unserialize($_SESSION["personne"]);
        $num_pers_ajoutee = $personneManager->ajouterPersonne($personne);

        if ($num_pers_ajoutee != 0) {
            ?>
            <img src="image/valid.png" alt="valid">
            <?php
            echo "La personne a été ajoutée !";
        }

        $salarieManager = new SalarieManager($pdo);
        $salarie = new Salarie($_POST);
        $retour = $salarieManager->ajouterSalarie($salarie, $num_pers_ajoutee);

        if ($retour != 0) {
            ?>
            <img src="image/valid.png" alt="valid">
            <?php
            echo "Le salarié a été ajouté !";
        }
    }
    ?>
    <h1>Ajouter une personne</h1>
    <form action="index.php?page=1" method="post">
        <div>
            <label for="per_nom">Nom : </label>
            <input type="text" name="per_nom" id="per_nom" required>
            <label for="per_prenom">Prénom : </label>
            <input type="text" name="per_prenom" id="per_prenom" required>
        </div>
        <div>
            <label for="per_tel">Téléphone : </label>
            <input type="tel" name="per_tel" id="per_tel" required>
            <label for="per_mail">Mail : </label>
            <input type="email" name="per_mail" id="per_mail" required>
        </div>
        <div>
            <label for="per_login">Login : </label>
            <input type="text" name="per_login" id="per_login" required>
            <label for="per_pwd">Mot de passe : </label>
            <input type="password" name="per_pwd" id="per_pwd" required>
        </div>
        <div>
            <label>Catégorie :
                <input checked type="radio" name="cat" id="cat_etu" value="cat_etu" required>
                <label for="cat_etu">Etudiant</label>
                <input type="radio" name="cat" id="cat_sal" value="cat_sal" required>
                <label for="cat_sal">Personnel</label>
            </label>
        </div>
        <input type="submit" value="Valider">
    </form>
    <?php
}

if (!empty($_POST["per_nom"]) && !empty($_POST["per_prenom"]) && !empty($_POST["per_tel"]) && !empty($_POST["per_mail"]) && !empty($_POST["per_login"]) && !empty($_POST["per_pwd"])) {
    $personne = new Personne($_POST);
    $_SESSION["personne"] = serialize($personne);
    if ($_POST["cat"] == "cat_etu") {
        if (empty($_POST["div_num"]) && empty($_POST["dep_num"])) {
            $divisionManager = new DivisionManager($pdo);
            $divisions = $divisionManager->getAllDivisions();
            $departementManager = new DepartementManager($pdo);
            $departements = $departementManager->getAllDepartements();
            ?>
            <h1>Ajouter un étudiant</h1>
            <form action="#" method="post">
                <label for="div_num">Année : </label>
                <select name="div_num" id="div_num" required>
                    <?php
                    foreach ($divisions as $division) {
                        ?>
                        <?php //print_r($division);?>
                        <option value="<?php echo $division->getDivNum() ?>"><?php echo $division->getDivNom() ?></option>
                        <?php
                    }
                    ?>
                </select>
                <label for="dep_num">Département : </label>
                <select name="dep_num" id="dep_num" required>
                    <?php
                    foreach ($departements as $departement) {
                        ?>
                        <option value="<?php echo $departement->getDepNum() ?>"><?php echo $departement->getDepNom() ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" value="Valider">
            </form>
            <?php
        }
    }
    if ($_POST["cat"] == "cat_sal") {
        if (empty($_POST["sal_telprof"]) && empty($_POST["fon_num"])) {
            $fonctionManager = new FonctionManager($pdo);
            $fonctions = $fonctionManager->getAllFonctions();
            ?>
            <h1>Ajouter un salarié</h1>
            <form action="#" method="post">
                <label for="sal_telprof">Téléphone : </label>
                <input name="sal_telprof" type="tel" id="sal_telprof" required>
                <label for="fon_num">Fonction : </label>
                <select name="fon_num" id="fon_num" required>
                    <?php
                    foreach ($fonctions as $fonction) {
                        ?>
                        <option value="<?php echo $fonction->getFonNum() ?>"><?php echo $fonction->getFonLibelle() ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" value="Valider">
            </form>
            <?php
        }
    }
}