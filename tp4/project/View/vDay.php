<?php
if ($_SESSION['rank'] == 'CUSTOMER') require('View/Switch/vFrontEnd.php');
else require('View/Switch/vBackEnd.php');


ob_start(); ?>
    <?= switchDay(1, false, $page['startDate']); ?>
    <div id="day">
        <?php foreach($dataDay as $dataEvent) {
            if (switchDay(2, $dataEvent, false)) { ?>
                <aside  <?php switchDay(3, $dataEvent, false) ?>>
                    <a href="index.php?action=event&amp;id=<?= htmlspecialchars($dataEvent['id']) ?>">
                        <h3><?= $dataEvent['name'] ?></h3><!--htmlspecialchar can break his display-->
                    </a>
                    <hr>
                    Début : <?= htmlspecialchars($dataEvent['displayStartTime']) ?><br>
                    <?php switchDay(4, $dataEvent, false); ?>
                    Places restantes : <?= htmlspecialchars($dataEvent['place']) ?>
                    <?php switchDay(5, $dataEvent, false); ?>
                </aside>
            <?php }
        } ?>
    </div>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
