<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$pageName = 'Liste';

$titleContent = 'Évènements du jour';

ob_start();
    if ($dateMonth != date('Y-m')) { ?>
        <li>
            <a href='index.php?action=reception'>
                <button>Mois en cours</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($date) ?>">
            <button>Mois de défilement</button>
        </a>
    </li>
    <?php if ($date != date('Y-m-d')) { ?>
        <li>
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>">
                <button>Jour en cours</button>
            </a>
        </li>
    <?php }
$menuContent = ob_get_clean();


ob_start(); ?>
    <header><?= displayDay(4, false, $date); ?></header>
    <div id="day">
        <?php foreach($dataDay as $dataEvent) { ?>
            <aside  <?php displayDay(1, $dataEvent, false) ?>>
                <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>">
                    <h3><?= htmlspecialchars($dataEvent['name']) ?></h3>
                </a>
                <hr>
                Début : <?= htmlspecialchars($dataEvent['startTime']) ?><br>
                <?php displayDay(2, $dataEvent, false); ?>
                Places restantes : <?= htmlspecialchars($dataEvent['place']) ?>
                <?php displayDay(3, $dataEvent, false); ?>
            </aside>
        <?php } ?>
    </div>
    <footer><?= displayDay(4, false, $date); ?></footer>
<?php $articleContent = ob_get_clean();


require('View/template.php');
