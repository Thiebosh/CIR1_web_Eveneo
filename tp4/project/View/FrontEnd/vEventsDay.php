<?php 
$pageName = 'Liste';

$legendContent = 'Evènements du jour';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <a href="index.php?action=list&amp;date=<?= htmlspecialchars($lastDay) ?>">
        <button><h3>Jour précédent</h3></button>
    </a>
    <h3><?= htmlspecialchars($showDate) ?></h3>
    <a href="index.php?action=list&amp;date=<?= htmlspecialchars($nextDay) ?>">
        <button><h3>Jour suivant</h3></button>
    </a>
<?php $asideContent = ob_get_clean();


ob_start();
    foreach($eventsDay as $event) {
        $startDate = strftime('%hHeure %i', strtotime($event['startdate']));
        if (cGetEventStatus($event['id'])) $status = 'Oui';
        else $status = 'Non';
        ?>
        <hr>
        <div class="event">
            <h3>
                <?= htmlspecialchars($event['name']) ?>
            </h3>
            Début : <?= htmlspecialchars($startDate) ?><br>
            Places restantes : <?= htmlspecialchars($event['nb_place']) ?><br>
            Inscrit : <?= htmlspecialchars($status) ?><br>
            <br>
            <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($event['id']) ?>"><button>Plus d'infos</button></a>
        </div>
        <hr>
    <?php }
$articleContent = ob_get_clean();

require('View/template.php');
