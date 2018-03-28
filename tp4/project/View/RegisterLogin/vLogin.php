<?php 
$pageName = $legendContent = 'Connexion';

$menuContent = '';

ob_start(); ?>
    <a href="index.php?action=entry"><button>Inscription</button></a>
<?php $asideContent = ob_get_clean();

ob_start(); ?>
    <fieldset><legend>Connexion</legend>
        <form method="post" action="index.php?action=login">
            <input type="text" id="login" name="login" placeholder="Identifiant">
            <input type="password" id="password" name="password" placeholder="Mot de passe">
            <input type="submit" value="Se connecter">
        </form>
    </fieldset>
<?php $articleContent = ob_get_clean();

require('View/template.php');
