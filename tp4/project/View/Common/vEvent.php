<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$pageName = "Détails";

$legendContent = "Détails de l'événement";

ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
    <li>
        <a href="index.php?action=list&amp;date=<?= htmlspecialchars($dataEvent['startdate']) ?>">
            <button>Tous les événements du <?= htmlspecialchars($startDateFr) ?></button>
        </a>
    </li>
<?php $menuContent = ob_get_clean();

$asideContent = '';

ob_start(); ?>
    <h3><?= htmlspecialchars($dataEvent['name']) ?></h3>
    Organisateur : <?= htmlspecialchars($dataEvent['login']) ?><br>
    Nombre de places restantes : <?= htmlspecialchars($dataEvent['place']) ?><br>
    <br>
    De <?= htmlspecialchars($startDateFr) ?> à <?= htmlspecialchars($endDateFr) ?> (Durée : <?= htmlspecialchars($dureeEvent) ?>)<br>
    <br>
    <fieldset class="describe">
        <legend>Description :</legend>
        <?= htmlspecialchars($dataEvent['description']) ?>
    </fieldset>
    <br>
    <?php displayEvent($id, $action) ?>
<?php $articleContent = ob_get_clean();

$asideBottomContent = '<a href="#"><button class="ancre"><h3>Haut de page</h3></button></a>';


require('View/template.php');

//<time><?= $billet['date'] ? ></time>//a voir
