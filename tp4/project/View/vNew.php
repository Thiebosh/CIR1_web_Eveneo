<?php 
$template['pageName'] = 'Création';

$template['titleContent'] = 'Création d\'événement';

ob_start(); ?>
    <menu>
        <li>
            <?php if ($page['dateMonth'] != date('Y-m')) { ?>
                <a href='index.php?action=reception'>
                    <button>Mois en cours</button>
                </a>
            <?php }
            else echo 'Mois en cours'; ?>
        </li>
        <li>
            <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($page['dateMonth']) ?>">
                <button>Mois de navigation</button>
            </a>
        </li>
        <li>
            <?php if ($page['date'] != date('Y-m-d')) { ?>
                <a href='index.php?action=list&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>'>
                    <button>Jour en cours</button>
                </a>
            <?php }
            else echo 'Jour en cours'; ?>
        </li>
        <li>
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars($page['date']) ?>">
                <button>Jour de navigation</button>
            </a>
        </li>
    </menu>
<?php $template['menuContent'] = ob_get_clean();

ob_start(); ?>
    <div>
        <?php 
        if (isset($reception['echec'])) {
            echo "<br><br>Erreur - Certains champs sont incorrects ou manquant : ";
            foreach($reception['echec'] as $message) {
                echo $message . ' ; ';
            }
        }
        ?>
    </div>
    <fieldset>
        <legend>Formulaire de création</legend>
        <form method="post" action="index.php?action=new&amp;date=<?= htmlspecialchars($page['date']) ?>">
            <label>Titre de l'événement : </label><label>Nombre de places : </label><br>
            <input type="text" id="name" name="name" placeholder="Titre">
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Places">
            <br>
            <label>Date de début : </label><label>Date de fin : </label><br>
            <input type="text" id="startDate" name="startDate" placeholder="Date de début" value=<?= $page['date'] ?>><!--liste deroulante préremplie-->
            <input type="text" id="endDate"   name="endDate"   placeholder="Date de fin"   value=<?= $page['date'] ?>><!--liste deroulante-->
            <br>
            <label>Description de l'événement : </label><br>
            <textarea id="description" name="description" placeholder="Description"></textarea>
            <br><br>
            <input type="hidden" name="script_new" value='true'>
            <input type="submit" value="Enregistrer">
        </form>
    </fieldset>
<?php $template['articleContent'] = ob_get_clean();


require('View/template.php');

/*
<select name="choix">

    <option value="choix1">Choix 1</option>

    <option value="choix2">Choix 2</option>

    <option value="choix3" selected="selected">Choix 3</option>

    <option value="choix4">Choix 4</option>

</select>
*/
