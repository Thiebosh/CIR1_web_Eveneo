<?php 
$title = 'Eveneo - Liste événements';


ob_start(); ?>
    <h1>Liste d'événements du <?= htmlspecialchars($infoPage['date']) ?></h1>
<?php $headerContent = ob_get_clean();


ob_start(); ?>
    <li>
        <form method="post" action="index.php">
            <input type="submit" value="Accueil">
        </form>
    </li>
<?php $menuContent = ob_get_clean();


ob_start(); ?>
    <form method="post" action="index.php?action=newEvent"><!--Préremplir le jour?-->
        <input type="submit" value="Ajouter une conférence">
    </form>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
    <?php //changer la requete : mettre truc correct et mettre en fetchall
    while ($data = $postsDay->fetch()) {
    ?>
        <div class="eventReception">
            <h3>
                <?= htmlspecialchars($data['title']) ?>
            </h3>
            <form method="post" action="index.php?action=detailEvent&amp;id=<?= $data['id'] ?>">
                <input type="submit" value="Plus d'infos">
            </form>
        </div>
    <?php
    }
    $postsDay->closeCursor();
    ?>
<?php $articleContent = ob_get_clean();


require('View/template.php');