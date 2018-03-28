<?php 
$pageName = 'Liste';

$legendContent = 'Evènements du jour';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= htmlspecialchars($lastDay) ?>>
        <input type="submit" value="Jour précédent">
    </form>

    <?= htmlspecialchars($showDate) ?>

    <form method="post" action="index.php?action=reception">
        <input type="hidden" name="date" value=<?= htmlspecialchars($nextDay) ?>>
        <input type="submit" value="Jour suivant">
    </form>
<?php $asideContent = ob_get_clean();


ob_start();
    foreach($eventsDay as $event) {
    ?>
        <div>
            <h3>
                <?= htmlspecialchars($event['name']) ?>
            </h3>
            début : <?= htmlspecialchars(strftime('%A %e %B %Y', strtotime($event['datestart']))) ?>
            <form method="post" action="index.php?action=detail">
                <input type="hidden" name="id" value=<?= htmlspecialchars($event['id']) ?>>
                <input type="submit" value="Plus d'infos">
            </form>
        </div>
    <?php
    }
$articleContent = ob_get_clean();

require('View/template.php');
