<?php
if ($_SESSION['rank'] = 'CUSTOMER') require('View/FrontEndSpecific.php');
else require('View/BackEndSpecific.php');


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
    displayDay($dataDay);
$articleContent = ob_get_clean();

$asideBottomContent = '<a href="#"><button class="ancre"><h3>Haut de page</h3></button></a>';


require('View/template.php');
