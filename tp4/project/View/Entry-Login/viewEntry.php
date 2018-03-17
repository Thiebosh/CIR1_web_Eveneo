<?php 
$title = 'Eveneo - Inscription';


ob_start(); ?>
    <h1>Page d'inscription</h1>
<?php $headerContent = ob_get_clean();


$menuContent = '';


if (isset($infoPage['login'])) {
    $asideContent = '';


    ob_start(); ?>
        <p>Inscription réussie!</p>
        <form method="post" action="index.php?action=login">
            <input type="submit" value="Se connecter">
        </form>
    <?php $articleContent = ob_get_clean();
}
else {
    ob_start(); ?>
        <form method="post" action="index.php?action=login">
            <input type="submit" value="Connexion">
        </form>
    <?php $asideContent = ob_get_clean();


    ob_start(); ?>
        <fieldset><legend>Inscription</legend>
            <form method="post" action="index.php?action=entry">
                <input type="text" id="login" name="login" placeholder="Identifiant">
                <div>
                    <input type="radio" id="Customer" name="rank" value="yes"><!--mettre coché par défaut-->
                    <label for="Customer">Client</label>
                    <input type="radio" id="Organizer" name="rank" value="none">
                    <label for="Organizer">Organisateur</label>
                </div>
                <input type="password" id="password" name="password" placeholder="Mot de passe">
                <input type="password" id="passwordVerif" name="passwordVerif" placeholder="Vérification du mot de passe">
                <input type="submit" value="S'inscrire">
            </form>
        </fieldset>
    <?php $articleContent = ob_get_clean();
}


require('View/template.php');
