<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$template['pageName'] = 'Détails';

$template['titleContent'] = 'Détails de l\'événement';

ob_start(); ?>
    <menu>
        <li>
            <?php if ($page['dateMonth'] != date('Y-m')) { ?>
                <a href='index.php?action=reception'>
                    <button>Mois en cours</button>
                </a>
            <?php }
            else echo 'Mois en cours'; ?>
        </li>
        <li>
            <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($page['dateMonth']) ?>">
                <button>Mois de navigation</button>
            </a>
        </li>
        <li>
            <?php if ($page['date'] != date('Y-m-d')) { ?>
                <a href='index.php?action=list&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>'>
                    <button>Jour en cours</button>
                </a>
            <?php }
            else echo 'Jour en cours'; ?>
        </li>
        <li>
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars($page['date']) ?>">
                <button>Jour de navigation</button>
            </a>
        </li>
    </menu>
<?php $template['menuContent'] = ob_get_clean();


ob_start(); ?>
    <div id="event">
        <header>
            <h3><?= $display['title'] ?></h3>
            <?php if (!isset($script)) { ?>
                Cet événement a déjà commencé ou est déjà fini
            <?php }
            else switchDisplayEvent(2, $script) ?>
        </header>

        <div>
            <aside>
                <?php switchDisplayEvent(1, $dataEvent['login']) ?>
                <span>Places restantes : </span><?= htmlspecialchars($dataEvent['place']) ?>
                <br>
                <span>Durée : </span>
                <?php foreach($display['duration'] as $displayPart) echo htmlspecialchars($displayPart).'<br>';?>
                <br>
                <span>Du </span><?= htmlspecialchars($display['startDate']) ?><span>
                <br>
                à </span><?= htmlspecialchars($display['startTime']) ?>
                <br>
                <span>Au </span><?= htmlspecialchars($display['endDate']) ?><span>
                <br>
                à </span><?= htmlspecialchars($display['endTime']) ?>
            </aside>
            <aside class="vLine"></aside>
            <aside>
                <span>Description :</span>
                <p><?= $dataEvent['description'] ?></p>
            </aside>
        </div>
    </div>
<?php $template['articleContent'] = ob_get_clean();


require('View/template.php');
