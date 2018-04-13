<?php 
$pageName = 'Modification';

$legendContent = 'Nouvelles informations de $data[\'title\']';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
    <!--si recoit date
    <li>
        <form method="post" action="index.php?action=allEvents&amp;date=< ?= $data['id']">
            <input type="submit" value="Liste des événements de < ?= htmlspecialchars($data['day']) ?>">
        </form>
    </li>
    -->
    <li>
        <a href="index.php?action=detailEvents&amp;id=<?= htmlspecialchars($data['id']) ?>"><button>Evénement</button></a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start();
    if (isset($data['echec'])) {
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
