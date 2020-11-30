<h1>Pour vous connecter</h1>

<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);

if (empty($_POST["per_login"]) || empty($_POST["per_pwd"]) || empty($_POST["captcha"])) {
    $_SESSION["premierChiffre"] = rand(1, 9);
    $_SESSION["secondChiffre"] = rand(1, 9);
    ?>
    <form action="index.php?page=11" method="post">
        <label>Nom d'utilisateur : <input type="text" name="per_login"></label>
        <label>Mot de passe : <input type="password" name="per_pwd"></label>
        <img src="image/nb/<?php echo $_SESSION["premierChiffre"] ?>.jpg" alt="premierChiffre">
        <?php echo " + " ?>
        <img src="image/nb/<?php echo $_SESSION["secondChiffre"] ?>.jpg" alt="premierChiffre">
        <?php echo " = " ?>
        <label><input type="text" name="captcha"></label>
        <input type="submit" name="valider" value="Valider">
    </form>
    <?php
} else {
    $per_login = $_POST["per_login"];
    $per_pwd = sha1(sha1($_POST["per_pwd"]) . SALT);
    echo $per_pwd;
    if ($personneManager->getConnexion($per_login, $per_pwd) != false && $_POST["captcha"] == ($_SESSION['premierChiffre'] + $_SESSION['secondChiffre'])) {
        $_SESSION["per_login"] = $per_login;
        $_SESSION["per_num"] = $personneManager->getConnexion($per_login, $per_pwd);
        header("Location: index.php?page=0");
        exit;
    } else {
        ?>
        <img src="image/erreur.png" alt="erreur">
        <?php
        echo "Identifiant et/ou mot de passe invalide.";
    }
}
