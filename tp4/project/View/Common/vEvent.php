<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$template['pageName'] = 'Détails';

$template['titleContent'] = 'Détails de l\'événement';

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
    <?php } ?>
    <li>
        <a href="index.php?action=list&amp;date=<?= htmlspecialchars($page['date']) ?>">
            <button>Jour de défilement</button>
        </a>
    </li>
<?php $template['menuContent'] = ob_get_clean();


ob_start(); ?>
    <div id="event">
        <div>
            <aside>
                <span>Organisateur : </span><?= htmlspecialchars($dataEvent['login']) ?>
                <br>
                <span>Places restantes : </span><?= htmlspecialchars($dataEvent['place']) ?>
                <br>
                <br>
                <span>Du </span><?= htmlspecialchars($display['startDate']) ?><span> à </span><?= htmlspecialchars($display['startTime']) ?>
                <br>
                <span>Au </span><?= htmlspecialchars($display['endDate']) ?><span> à </span><?= htmlspecialchars($display['endTime']) ?>
                <br>
                <br>
                <?= $display['duration'] ?>
            </aside>
            <aside class="vLine"></aside>
            <aside>
                <span>Description :</span>
                <p><?= htmlspecialchars($dataEvent['description']) ?></p>
            </aside>
        </div>
        
        <footer><?php displayEvent($script) ?></footer>
    </div>
<?php $template['articleContent'] = ob_get_clean();


require('View/template.php');
