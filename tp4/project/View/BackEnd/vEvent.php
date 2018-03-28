<?php 
$pageName = 'Détails';

$legendContent = 'Détails de l\'événement';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <a href="index.php?action=lastEvent"><button>Evénement précédent</button></a>

    <?= htmlspecialchars($data['title']) ?>

    <a href="index.php?action=nextEvent"><button>Evénement suivant</button></a>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
    <h3><?= $dataEvent['nameConf'] ?></h3>
    Organisateur : <?= $dataEvent['organizer'] ?>
    durée : <?= $dureeEvent ?>
    de <?= htmlspecialchars(strftime('%A %e %B %Y, %Hheures %i', strtotime($event['datestart']))) ?> à <?= htmlspecialchars(strftime('%A %e %B %Y, %Hheures %i', strtotime($event['dateend']))) ?>
    <?= htmlspecialchars($dataEvent['place']) ?>
    <?= htmlspecialchars($dataEvent['describeConf']) ?>

    <a href="index.php?action=modifyEvents&amp;id=<?= htmlspecialchars($data['id']) ?>"><button>Modifier l'événement</button></a>
    <a href="index.php?action=deleteEvents&amp;id=<?= htmlspecialchars($data['id']) ?>"><button>Supprimer l'événement</button></a>
<?php $articleContent = ob_get_clean();

require('View/template.php');
