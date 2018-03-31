<?php 
$pageName = $legendContent = 'Inscription';

$menuContent = '';

ob_start(); ?>
    <a href="index.php?action=login"><button>Connexion</button></a>
<?php $asideContent = ob_get_clean();

ob_start(); ?>
    <fieldset>
        <form method="post" action="index.php?action=entry">
            <input type="hidden" name="script_register" value="true">
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

require('View/RegisterLogin/templateRL.php');
