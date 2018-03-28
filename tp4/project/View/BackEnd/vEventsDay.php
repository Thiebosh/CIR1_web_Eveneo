<?php 
$pageName = 'Liste';

$legendContent = 'Evènements du jour';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <a href="index.php?action=lastDay"><button>Jour précédent</button></a>

    <?= htmlspecialchars($infoPage['date'].' '.$infoPage['month'].' '.$infoPage['year']) ?>

    <a href="index.php?action=nextDay"><button>Jour suivant</button></a>
<?php $asideContent = ob_get_clean();


ob_start();
    foreach($listEventsDay as $event) {
    ?>
        <div class="event">
            <h3>
                <?= htmlspecialchars($event['name']) ?>
            </h3>
            début : <?= htmlspecialchars(strftime('%A %e %B %Y', strtotime($event['datestart']))) ?>
            <a href="index.php?action=detailEvent&amp;id=<?= htmlspecialchars($event['id']) ?>"><button>Plus d'infos</button></a>
        </div>
    <?php
    }
    ?>
    <a href="index.php?action=newEvent"><button>Ajouter une conférence</button></a><!--Préremplir le jour-->
    <?php
$articleContent = ob_get_clean();

require('View/template.php');