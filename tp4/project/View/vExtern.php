<?php
ob_start(); ?>
    <fieldset>
        <legend>Identifiants</legend>
        <?php if ($page['actual'] == 'login') { ?>
            <form method="post" action="index.php?action=login">
                <table>
                    <tr>
                        <td><label>Nom de compte : </label></td>
                        <td><input type="text" id="login" name="login" placeholder="Nom de compte"></td>
                    </tr>
                    <tr>
                        <td><label>Mot de passe : </label></td>
                        <td><input type="password" id="password" name="password" placeholder="Mot de passe"></td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="script" value="login">
                <input type="submit" value="Se connecter">
            </form>
        <?php }
        else if ($page['actual'] == 'register') { ?>
            <form method="post" action="index.php?action=register">
                <table>
                    <tr>
                        <td><label>Nom de compte : </label></td>
                        <td><input type="text" id="login" name="login" placeholder="Nom de compte"></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td><label>Mot de passe : </label></td>
                        <td><input type="password" id="password" name="password" placeholder="Mot de passe"></td>
                    </tr>
                    <tr>
                        <td><label>Vérification : </label></td>
                        <td><input type="password" id="passwordVerif" name="passwordVerif" placeholder="Mot de passe"></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td>
                            <input type="radio" id="Customer" name="rank" value="CUSTOMER" checked>
                            <label for="Customer">Client</label>
                        </td>
                        <td>
                            <input type="radio" id="Organizer" name="rank" value="ORGANIZER">
                            <label for="Organizer">Organisateur</label>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="script" value="register">
                <input type="submit" value="S'inscrire">
            </form>
        <?php }?>
    </fieldset>
    <br>
    <?php if ($page['actual'] == 'login') { ?>
        <span>Pas encore membre?</span>
        <a href="index.php?action=register">
            <button>S'inscrire</button>
        </a>
    <?php }
    else if ($page['actual'] == 'register') { ?>
        <span>Déjà inscrit?</span>
        <a href="index.php?action=login">
            <button>Se connecter</button>
        </a>
    <?php } ?>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
