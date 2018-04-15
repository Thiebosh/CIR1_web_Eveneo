<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/Switch/vFrontEnd.php');
else require('View/Switch/vBackEnd.php');


ob_start(); ?>
    <div id="event">
        <header>
            <h3><?= $dataEvent['name'] ?></h3>
            <?php if (!isset($script)) { ?>
                Cet événement a déjà commencé ou est déjà fini
            <?php }
            else switchEvent(1, $script) ?>
        </header>

        <div>
            <aside>
                <?php switchEvent(2, $dataEvent['login']) ?>
                <span>Places restantes : </span><?= htmlspecialchars($dataEvent['place']) ?>
                <br>
                <span>Durée : </span>
                <?php foreach($page['duration'] as $pagePart) echo htmlspecialchars($pagePart).'<br>';?>
                <br>
                <span>Du </span><?= htmlspecialchars($page['startDate']) ?><span>
                <br>
                à </span><?= htmlspecialchars($page['startTime']) ?>
                <br>
                <span>Au </span><?= htmlspecialchars($page['endDate']) ?><span>
                <br>
                à </span><?= htmlspecialchars($page['endTime']) ?>
            </aside>
            <aside class="vLine"></aside>
            <aside>
                <span>Description :</span>
                <p><?= $dataEvent['description'] ?></p><!--lui appliquer htmlspecialchar le detruit-->
            </aside>
        </div>
    </div>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
