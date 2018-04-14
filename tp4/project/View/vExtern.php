<?php
function switchDisplayExtern($part, $page) {
    if ($part == 1) {
        if ($page == 'Connexion') { ?>
            <form method="post" action="index.php?action=login">
                <label>Nom de compte : </label>
                <input type="text" id="login" name="login" placeholder="Nom de compte">
                <br>
                <label>Mot de passe : </label>
                <input type="password" id="password" name="password" placeholder="Mot de passe">
                <br>
                <br>
                <input type="hidden" name="script_login" value="true">
                <input type="submit" value="Se connecter">
            </form>
        <?php }
        else if ($page == 'Inscription') { ?>
            <form method="post" action="index.php?action=register">
                <label>Nom de compte : </label>
                <input type="text" id="login" name="login" placeholder="Nom de compte">
                <br>
                <br>
                <label>Mot de passe : </label>
                <input type="password" id="password" name="password" placeholder="Mot de passe">
                <br>
                <label>Vérification : </label>
                <input type="password" id="passwordVerif" name="passwordVerif" placeholder="Mot de passe">
                <br>
                <br>
                <input type="radio" id="Customer" name="rank" value="CUSTOMER" checked>
                <label for="Customer">Client</label>
                <br>
                <input type="radio" id="Organizer" name="rank" value="ORGANIZER">
                <label for="Organizer">Organisateur</label>
                <br>
                <br>
                <input type="hidden" name="script_register" value="true">
                <input type="submit" value="S'inscrire">
            </form>
        <?php }
    }
    else if ($part == 2) {
        if ($page == 'Connexion') { ?>
            <span>Pas encore membre?</span>
            <a href="index.php?action=register">
                <button>S'inscrire</button>
            </a>
        <?php }
        else if ($page == 'Inscription') { ?>
            <span>Déjà inscrit?</span>
            <a href="index.php?action=login">
                <button>Se connecter</button>
            </a>
        <?php }
    }
}


$template['titleContent'] = 'Bienvenue sur Eveneo';

$template['menuContent'] = '';

ob_start(); ?>
    <fieldset>
        <legend>Identifiants</legend>
        <?php switchDisplayExtern(1, $template['pageName']); ?>
    </fieldset>
    <?php switchDisplayExtern(2, $template['pageName']); ?>
<?php $template['articleContent'] = ob_get_clean();


require('View/template.php');
