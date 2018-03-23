<?php 
$pageName = 'Connexion';

$menuContent = '';

$legendContent = 'Connexion';

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

require('View/template.php');
