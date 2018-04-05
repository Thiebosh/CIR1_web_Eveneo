<?php 
$pageName = 'Création';

$legendContent = 'Informations du nouvel événement';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
    <li>
        <a href="index.php?action=allEvents&amp;date=<?= htmlspecialchars($date) ?>">
            Liste des événements de <?= htmlspecialchars($showDate) ?>
        </a>
    </li>
    <!--si recoit date
    <li>
        <form method="post" action="index.php?action=allEvents&amp;date=< ?= $data['id']">
            <input type="submit" value="">
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
    <form method="post" action="index.php?action=new">
        <input type="text" id="name" name="name" placeholder="Titre de l'événement">
        <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Nombre de places">
        <br>
        <input type="text" id="startDate" name="startDate" placeholder="Date de début"><!--liste deroulante préremplie si infos (sauf heure)-->
        <input type="text" id="endDate" name="endDate" placeholder="Date de fin"><!--liste deroulante / bouton pour choisir de mettre une durée ou une date de fin-->
        <br>
        <textarea id="description" name="description" placeholder="Description de l'événement"></textarea>
        <br><br>
        <input type="submit" value="Enregistrer">
    </form>
<?php $articleContent = ob_get_clean();


require('View/template.php');
