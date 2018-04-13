<?php 
$template['pageName'] = 'Modification';

$template['titleContent'] = 'Édition d\'événement';

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
    <li>
        <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($page['id']) ?>">
            <button>Evénement de défilement</button>
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
        <legend><?= $page['name'] ?></legend>
        <form method="post" action="index.php?action=edit&amp;id=<?= htmlspecialchars($page['id']) ?>">
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="nbPlaces" value=<?= $page['place'] ?>>
            <br>
            <input type="text" id="endDate" name="endDate" placeholder="Date de fin" value=<?= $page['enddate'] ?>><!--liste deroulante preremplie-->
            <br>
            <br>
            <textarea id="description" name="description" placeholder="description"><?= $page['description'] ?></textarea>
            <br>
            <br>
            <input type="hidden" name="script_edit" value='true'>
            <input type="submit" value="Modifier">
        </form>
    </fieldset>
<?php $template['articleContent'] = ob_get_clean();


require('View/Common/template.php');
