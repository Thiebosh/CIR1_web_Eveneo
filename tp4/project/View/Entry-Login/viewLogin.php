<?php 
$title = 'Eveneo - Connexion';


ob_start(); ?>
    <h1>Page de connexion</h1>
<?php $headerContent = ob_get_clean();


$menuContent = '';


if (isset($_SESSION['login'])) {
    $asideContent = '';


    ob_start(); ?>
        <p>Connexion réussie!</p>
        <form method="post" action="index.php">
            <input type="submit" value="Aller vers l'accueil">
        </form>
    <?php $articleContent = ob_get_clean();
}
else {
    ob_start(); ?>
        <form method="post" action="index.php?action=entry">
            <input type="submit" value="Inscription">
        </form>
    <?php $asideContent = ob_get_clean();


    ob_start(); ?>
        <fieldset><legend>Connexion</legend>
            <form method="post" action="index.php?action=login"><!--modifier-->
                <input type="text" id="login" name="login" placeholder="Identifiant">
                <input type="password" id="password" name="password" placeholder="Mot de passe">
                <input type="submit" value="Se connecter">
            </form>
        </fieldset>
    <?php $articleContent = ob_get_clean();
}


require('View/template.php');
