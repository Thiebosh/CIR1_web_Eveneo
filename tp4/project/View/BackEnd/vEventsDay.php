<?php 
$pageName = 'Liste';

$legendContent = 'Evènements du jour';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($lastDay) ?>">Jour précédent</a>
    <?= htmlspecialchars($showDate) ?>
    <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($nextMonth) ?>">Jour suivant</a>
<?php $asideContent = ob_get_clean();


ob_start();
    foreach($eventsDay as $event) {
    $startDate = strftime('%hHeure %i', strtotime($event['startdate']));
    ?>
        <hr>
        <div class="event">
            <h3>
                <?= htmlspecialchars($event['name']) ?>
            </h3>
            Début : <?= htmlspecialchars($startDate) ?><br>
            Places restantes : <?= htmlspecialchars($event['nb_place']) ?><br>
            <br>
            <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($event['id']) ?>"><button>Plus d'infos</button></a>
        </div>
        <hr>
    <?php
    }
    ?>
    <a href="index.php?action=new&amp;date=<?= htmlspecialchars($date) ?>"><button>Ajouter une conférence</button></a>
    <?php
$articleContent = ob_get_clean();

require('View/template.php');