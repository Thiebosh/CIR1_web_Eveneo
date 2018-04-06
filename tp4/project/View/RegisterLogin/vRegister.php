<?php 
$pageName = $legendContent = 'Inscription';

ob_start(); ?>
    <fieldset>
        <form method="post" action="index.php?action=register">
            <input type="hidden" name="script_register" value="true">

            <input type="text" id="login" name="login" placeholder="Identifiant">
            <br>
            <br>
            <input type="password" id="password" name="password" placeholder="Mot de passe">
            <br>
            <input type="password" id="passwordVerif" name="passwordVerif" placeholder="Vérification du mot de passe">
            <br>
            <br>
            <input type="radio" id="Customer" name="rank" value="yes" checked>
            <label for="Customer">Client</label>
            <br>
            <input type="radio" id="Organizer" name="rank" value="yes">
            <label for="Organizer">Organisateur</label>
            <br>
            <br>
            <input type="submit" value="S'inscrire">
        </form>
    </fieldset>
<?php $articleContent = ob_get_clean();

ob_start(); ?>
    Déjà inscrit? 
    <a href="index.php?action=login"><button>Se connecter</button></a>
<?php $asideContent = ob_get_clean();

require('View/RegisterLogin/templateRL.php');
