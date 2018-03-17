<?php 
$title = 'Eveneo - Accueil';


ob_start(); ?>
    <h1>Accueil</h1>
    <p>Liste des événements du mois de <?= $infoPage['month'] ?></p>
<?php $headerContent = ob_get_clean();


$menuContent = '';


ob_start(); ?>
    <fieldset><legend>Changer de mois</legend>
        <form method="post" action="index.php?action=lastMonth">
            <input type="submit" value="Voir le mois précédent">
        </form>

        <form method="post" action="index.php?action=nextMonth">
            <input type="submit" value="Voir le mois suivant">
        </form>

        <form method="post" action="index.php?action=newEvent">
            <input type="submit" value="Ajouter une conférence">
        </form>
    </fieldset>
<?php $asideContent = ob_get_clean();


ob_start(); ?>
    <?php //changer les requetes : mettre truc correct et mettre en fetchall
    while ($dataDay = $postsMonth->fetch()) {
        while ($data = $postsDay->fetch())     {
        ?>
            <div class="eventReception">
                <h3>
                    <?= htmlspecialchars($data['title']) ?>
                </h3>
            </div>
        <?php
        }
        $postsDay->closeCursor();
        
        if ($infoPage['nbEvent'] > 5) {//ajoute bouton au template
            ?>
            <form method="post" action="index.php?action=allEvent">
                <input type="submit" value="Voir plus de conférences">
            </form>
            <?php
        }
    }
    $postsMonth->closeCursor();
    ?>
<?php $articleContent = ob_get_clean();


require('View/template.php');
