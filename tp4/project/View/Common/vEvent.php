<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/vFrontEnd.php');
else require('View/vBackEnd.php');


$pageName = "Détails";

$titleContent = "Détails de l'événement";

ob_start();
    if ($dateMonth != date('Y-m')) { ?>
        <li>
            <a href='index.php?action=reception'>
                <button>Mois en cours</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="index.php?action=reception&amp;date=<?= htmlspecialchars($dateMonth) ?>">
            <button>Mois de défilement</button>
        </a>
    </li>
    <?php if ($dataEvent['startdate'] != date('Y-m-d')) { ?>
        <li>
            <a href="index.php?action=list&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>">
                <button>Jour en cours</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="index.php?action=list&amp;date=<?= htmlspecialchars($date) ?>">
            <button>Jour de défilement</button>
        </a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <div id="event">
        <div>
            <aside>
                <span>De</span> 
                <?= htmlspecialchars($startDateFr) ?> 
                <br>
                <span>A</span> 
                <?= htmlspecialchars($endDateFr) ?>
                <br>
                <span>Durée :</span> 
                <?= htmlspecialchars($dureeEvent) ?>
                <br>
                <br>
                <span>Organisateur :</span> 
                <?= htmlspecialchars($dataEvent['login']) ?>
                <br>
                <span>Places restantes :</span> 
                <?= htmlspecialchars($dataEvent['place']) ?>
            </aside>
            <aside class="vLine"></aside>
            <aside>
                <span>Description :</span> 
                <p><?= htmlspecialchars($dataEvent['description']) ?></p>
            </aside>
        </div>
        
        <footer><?php displayEvent($id, $action) ?></footer>
    </div>
<?php $articleContent = ob_get_clean();


require('View/template.php');

//<time><?= $billet['date'] ? ></time>//a voir
