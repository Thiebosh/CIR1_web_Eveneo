<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$template['pageName'] = 'Liste';

$template['titleContent'] = 'Évènements du jour';

ob_start();
    if ($page['dateMonth'] != date('Y-m')) { ?>
        <li>
            <a href='index.php?action=reception'>
                <button>Mois en cours</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($page['dateMonth']) ?>">
            <button>Mois de défilement</button>
        </a>
    </li>
    <?php if ($page['date'] != date('Y-m-d')) { ?>
        <li>
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>">
                <button>Jour en cours</button>
            </a>
        </li>
    <?php }
$template['menuContent'] = ob_get_clean();


ob_start(); ?>
    <?= switchDisplayDay(4, false, $page['date']); ?>
    <div id="day">
        <?php foreach($dataDay as $dataEvent) { ?>
            <aside  <?php switchDisplayDay(1, $dataEvent, false) ?>>
                <a href="index.php?action=detail&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>">
                    <h3><?= htmlspecialchars($dataEvent['name']) ?></h3>
                </a>
                <hr>
                Début : <?= htmlspecialchars($dataEvent['startTime']) ?><br>
                <?php switchDisplayDay(2, $dataEvent, false); ?>
                Places restantes : <?= htmlspecialchars($dataEvent['place']) ?>
                <?php switchDisplayDay(3, $dataEvent, false); ?>
            </aside>
        <?php } ?>
    </div>
<?php $template['articleContent'] = ob_get_clean();


require('View/Common/template.php');
