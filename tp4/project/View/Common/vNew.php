<?php 
$template['pageName'] = 'Création';

$template['titleContent'] = 'Création d\'événement';

ob_start();
    if ($page['dateMonth'] != date('Y-m')) { ?>
        <li>
            <a href='index.php?action=reception'>
                <button>Mois en cours</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($page['dateMonth']) ?>">
            <button>Mois de défilement</button>
        </a>
    </li>
    <?php if ($page['date'] != date('Y-m-d')) { ?>
        <li>
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>">
                <button>Jour en cours</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="index.php?action=list&amp;date=<?= htmlspecialchars($page['date']) ?>">
            <button>Jour de défilement</button>
        </a>
    </li>
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
        <legend>formulaire</legend>
        <form method="post" action="index.php?action=new&amp;date=<?= htmlspecialchars($page['date']) ?>">
            <input type="text" id="name" name="name" placeholder="Titre de l'événement">
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Nombre de places">
            <br>
            <input type="text" id="startDate" name="startDate" placeholder="Date de début" value=<?= $page['date'] ?>><!--liste deroulante préremplie-->
            <input type="text" id="endDate"   name="endDate"   placeholder="Date de fin"   value=<?= $page['date'] ?>><!--liste deroulante-->
            <br>
            <textarea id="description" name="description" placeholder="Description de l'événement"></textarea>
            <br><br>
            <input type="hidden" name="script_new" value='true'>
            <input type="submit" value="Enregistrer">
        </form>
    </fieldset>
<?php $template['articleContent'] = ob_get_clean();


require('View/Common/template.php');
