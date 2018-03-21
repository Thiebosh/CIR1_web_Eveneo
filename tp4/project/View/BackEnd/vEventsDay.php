<?php 
$pageName = 'Liste';


ob_start(); ?>
    <li>
        <form method="post" action="index.php">
            <input type="submit" value="Accueil">
        </form>
    </li>
<?php $menuContent = ob_get_clean();


$legendContent = 'Evènements du jour';


ob_start(); ?>
    <form method="post" action="index.php?action=lastDay">
        <input type="submit" value="Jour précédent">
    </form>

    <?= $infoPage['date'].' '.$infoPage['month'].' '.$infoPage['year'] ?>

    <form method="post" action="index.php?action=nextDay">
        <input type="submit" value="Jour suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start();
initialisation1 : setlocale(LC_TIME, 'fr_FR');
initialisation2 : date_default_timezone_set('UTC');
    foreach($listEventsDay as $event) {
    ?>
        <div class="event">
        <h3>
            <?= $event['name'] ?>
        </h3>
        début : <?= strftime('%A %e %B %Y', strtotime($event['datestart'])) ?>
            <form method="post" action="index.php?action=detailEvent&amp;id=<?= $event['id'] ?>">
                <input type="submit" value="Plus d'infos">
            </form>
        </div>
    <?php
    }
    ?>
    <form method="post" action="index.php?action=newEvent"><!--Préremplir le jour-->
        <input type="submit" value="Ajouter une conférence">
    </form>
    <?php
$articleContent = ob_get_clean();

require('View/template.php');