<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/Switch/vFrontEnd.php');
else require('View/Switch/vBackEnd.php');


ob_start(); ?>
    <div id="event">
        <header>
            <h3><?= htmlspecialchars($dataEvent['name']) ?></h3>
            <?php if (!isset($script)) echo 'Le début de cet événement est déjà passé';
            else switchEvent(1, $script) ?>
        </header>

        <div>
            <aside>
                <?php switchEvent(2, $dataEvent) ?>
                <div><span>Places restantes : </span><?= htmlspecialchars($dataEvent['place']) ?></div>
                <div>
                    <span>Durée : </span>
                    <?php foreach($page['duration'] as $durationPart) echo htmlspecialchars($durationPart).'<br>';?>
                </div>
                <div><br></div>
                <div>
                    <span>Du </span><?= htmlspecialchars($page['displayStartDate']) ?><span>
                    <br>
                    à </span><?= htmlspecialchars($page['displayStartTime']) ?>
                </div>
                <div>
                    <span>Au </span><?= htmlspecialchars($page['displayEndDate']) ?><span>
                    <br>
                    à </span><?= htmlspecialchars($page['displayEndTime']) ?>
                </div>
            </aside>
            <aside class="vLine"></aside>
            <aside>
                <span>Description :</span>
                <p><?= htmlspecialchars($dataEvent['description']) ?></p>
            </aside>
        </div>
    </div>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
