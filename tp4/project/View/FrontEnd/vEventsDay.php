<?php 
$pageName = 'Liste';


ob_start(); ?>
    <li>
        <!--<a href="index.php?action=reception">Accueil</a>-->
        <form method="post" action="index.php?action=reception">
            <input type="submit" value="Accueil">
        </form>
    </li>
<?php $menuContent = ob_get_clean();


$legendContent = 'Evènements du jour';


ob_start(); ?>
    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= $lastDay ?>>
        <input type="submit" value="Jour précédent">
    </form>

    <?= $showDate ?>

    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= $nextDay ?>>
        <input type="submit" value="Jour suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start();
    foreach($eventsDay as $event) {
    ?>
        <div>
            <h3>
                <?= $event['name'] ?>
            </h3>
            début : <?= strftime('%A %e %B %Y', strtotime($event['datestart'])) ?>
            <form method="post" action="index.php?action=detail">
                <input type="hidden" name="id" value=<?= $event['id'] ?>>
                <input type="submit" value="Plus d'infos">
            </form>
        </div>
    <?php
    }
$articleContent = ob_get_clean();

require('View/template.php');
