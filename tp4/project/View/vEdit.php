<?php 
$template['pageName'] = 'Modification';

$template['titleContent'] = 'Édition d\'événement';

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
        <li>
            <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($page['id']) ?>">
                <button>Evénement de navigation</button>
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
        <legend>Formulaire d'édition</legend>
        <form method="post" action="index.php?action=edit&amp;id=<?= htmlspecialchars($page['id']) ?>">
            <label>Nouveau titre : </label><label>Nouveau nombre de places restantes : </label><br>
            <input type="text" id="name" name="name" placeholder="Titre" value=<?= htmlspecialchars($page['name']) ?>>
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Places" value=<?= htmlspecialchars($page['place']) ?>>
            <br>
            <label>Nouvelle date de fin : </label><br>
            <input type="text" id="endDate" name="endDate" placeholder="Date de fin" value=<?= htmlspecialchars($page['enddate']) ?>><!--liste deroulante preremplie-->
            <br>
            <br>
            <label>Nouvelle description : </label><br>
            <textarea id="description" name="description" placeholder="Description"><?= $page['description'] ?></textarea>
            <br>
            <br>
            <input type="hidden" name="startDate" value=<?= htmlspecialchars($page['startdate']) ?>>
            <input type="hidden" name="script_edit" value='true'>
            <input type="submit" value="Modifier">
        </form>
    </fieldset>
<?php $template['articleContent'] = ob_get_clean();


require('View/template.php');
