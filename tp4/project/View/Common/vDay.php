<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$pageName = 'Liste';

$legendContent = 'Evènements du jour';

ob_start(); ?>
    <li>
        <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($date) ?>"><button>Accueil</button></a>
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
    foreach($dataDay as $dataEvent) {?>
        <hr>
        <div class="event">
            <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>">
                <h3><?= htmlspecialchars($dataEvent['name']) ?></h3>
            </a>
            Début : <?= htmlspecialchars($dataEvent['startTime']) ?><br>
            <?php displayDay(1, $dataEvent, false); ?>
            Places restantes : <?= htmlspecialchars($dataEvent['place']) ?>
            <?php displayDay(2, $dataEvent, false); ?>
        </div>
        <hr>
    <?php } ?>
    <?php displayDay(3, false, $date);
$articleContent = ob_get_clean();

$asideBottomContent = '<a href="#"><button class="ancre"><h3>Haut de page</h3></button></a>';


require('View/template.php');
