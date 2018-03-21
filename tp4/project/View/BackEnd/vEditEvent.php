<?php 
$pageName = 'Modification';


ob_start(); ?>
    <li>
        <form method="post" action="index.php">
            <input type="submit" value="Accueil">
        </form>
    </li>
    <!--envoie date
    <li>
        <form method="post" action="index.php?action=allEvents&amp;date=< ?= $data['id']">
            <input type="submit" value="Liste des événements de < ?= htmlspecialchars($data['day']) ?>">
        </form>
    </li>
    -->
    <li>
        <form method="post" action="index.php?action=detailEvents&amp;id=< ?= $data['id']">
            <input type="submit" value="Evénement">
        </form>
    </li>
<?php $menuContent = ob_get_clean();


$legendContent = 'Nouvelles informations de $data[\'title\']';


ob_start();
    if ($infoPage['echec']) {
        echo 'Erreur : certains champs sont incorrects ou manquant';
    }
$asideContent = ob_get_clean();


ob_start(); ?>
    <form method="post" action="index.php?action=saveEvent">
        <input type="text" id="nbPlaces" name="nbPlaces" placeholder="nbPlaces"><!--preremplie-->
        <input type="text" id="duree" name="duree" placeholder="duree"><!--liste deroulante preremplie / bouton pour choisir de mettre une durée ou une date de fin-->
        <textarea id="description" name="description" placeholder="description"></textarea><!--prerempli-->
        
        <input type="submit" value="Enregistrer">
    </form>
<?php $articleContent = ob_get_clean();


require('View/template.php');
