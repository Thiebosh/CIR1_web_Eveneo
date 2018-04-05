<?php 
$pageName = 'Création';

$legendContent = 'Informations du nouvel événement';


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
<?php $menuContent = ob_get_clean();


ob_start();
    if ($_POST['echec']) {
        echo 'Erreur : certains champs sont incorrects ou manquant';
    }
$asideContent = ob_get_clean();


ob_start(); ?>
    <form method="post" action="index.php?action=saveEvent">
        <input type="text" id="nameEvent" name="nameEvent" placeholder="nom">
        <input type="text" id="nbPlaces" name="nbPlaces" placeholder="nbPlaces">
        <input type="text" id="dateDebut" name="dateDebut" placeholder="dateDebut"><!--liste deroulante préremplie si infos (sauf heure)-->
        <input type="text" id="duree" name="duree" placeholder="duree"><!--liste deroulante / bouton pour choisir de mettre une durée ou une date de fin-->
        <textarea id="description" name="description" placeholder="description"></textarea>
        
        <input type="submit" value="Enregistrer">
    </form>
<?php $articleContent = ob_get_clean();


require('View/template.php');
