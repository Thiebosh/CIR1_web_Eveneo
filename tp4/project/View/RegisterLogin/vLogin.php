<?php 
$pageName = $legendContent = 'Connexion';

ob_start(); ?>
    <fieldset>
        <form method="post" action="index.php?action=login">
            <input type="hidden" name="script_login" value="true">
            
            <input type="text" id="login" name="login" placeholder="Identifiant">
            <br>
            <input type="password" id="password" name="password" placeholder="Mot de passe">
            <br>
            <br>
            <input type="submit" value="Se connecter">
        </form>
    </fieldset>
<?php $articleContent = ob_get_clean();

ob_start(); ?>
    Pas encore membre? 
    <a href="index.php?action=register"><button>S'inscrire</button></a>
<?php $asideContent = ob_get_clean();

require('View/RegisterLogin/templateRL.php');
