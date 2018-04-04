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
    <h3>
        <?= htmlspecialchars($dataEvent['nameConf']) ?>
    </h3>
    Organisateur : <?= htmlspecialchars($dataEvent['organizer']) ?>
    durée : <?= htmlspecialchars($dureeEvent) ?>
    de <?= htmlspecialchars($dateStart) ?> à <?= htmlspecialchars($dateEnd) ?>
    <?= htmlspecialchars($dataEvent['place']) ?>
    <?= htmlspecialchars($dataEvent['describeConf']) ?>


    <a href="index.php?action=statusEvents&amp;id=<?= htmlspecialchars($data['id']) ?>"><button>
        <?php
        if (!$current) {
            echo 'S\'inscrire à l\'événement';
        }
        else {
            echo 'Se désinscrire de l\'événement';
        }
        ?>
    </button></a>
<?php $articleContent = ob_get_clean();

require('View/template.php');

//<time><?= $billet['date'] ? ></time>//a voir
