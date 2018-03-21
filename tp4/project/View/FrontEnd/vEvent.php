<?php 
$pageName = 'Détails';


ob_start(); ?>
    <li>
        <form method="post" action="index.php">
            <input type="submit" value="Accueil">
        </form>
    </li>
<?php $menuContent = ob_get_clean();


$legendContent = 'Détails de l\'événement';


ob_start(); ?>
    <form method="post" action="index.php?action=lastEvent">
        <input type="submit" value="Evénement précédent">
    </form>

    <?= $data['title'] ?>

    <form method="post" action="index.php?action=nextEvent">
        <input type="submit" value="Evénement suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
initialisation1 : setlocale(LC_TIME, 'fr_FR');
initialisation2 : date_default_timezone_set('UTC');
    <h3>
        <?= $dataEvent['nameConf'] ?>
    </h3>
    Organisateur : <?= $dataEvent['organizer'] ?>
    durée : <?= $dureeEvent ?>
    de <?= strftime('%A %e %B %Y, %Hheures %i', strtotime($event['datestart'])) ?> à <?= strftime('%A %e %B %Y, %Hheures %i', strtotime($event['dateend'])) ?>
    <?= $dataEvent['place'] ?>
    <?= $dataEvent['describeConf'] ?>

    <form method="post" action="index.php?action=statusEvents&amp;id=<?= $data['id'] ?>">
        <?php
        if (!$current) {
            echo '<input type="submit" value="S\'inscrire à l\'événement">';
        }
        else {
            echo '<input type="submit" value="Se désinscrire de l\'événement">';
        }
        ?>
    </form>
<?php $articleContent = ob_get_clean();

require('View/template.php');

//<time><?= $billet['date'] ? ></time>
