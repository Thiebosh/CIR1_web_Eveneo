<?php 
$title = 'Eveneo - Création événement';


ob_start(); ?>
    <h1>Création d'un événement</h1>
<?php $headerContent = ob_get_clean();


ob_start(); ?>
    <li>
        <form method="post" action="index.php">
            <input type="submit" value="Accueil">
        </form>
    </li>
    <!--si envoie date
    <li>
        <form method="post" action="index.php?action=allEvents&amp;date=< ?= $data['id']">
            <input type="submit" value="Liste des événements de < ?= htmlspecialchars($data['day']) ?>">
        </form>
    </li>
    -->
<?php $menuContent = ob_get_clean();


ob_start();
    if ($infoPage['echec']) {
        echo 'Erreur : certains champs sont incorrects ou manquant';
    }
$asideContent = ob_get_clean();


ob_start(); ?>
    <fieldset><legend>Informations sur la conférence</legend><!--ajuster types de champ et noms-->
        <form method="post" action="index.php?action=saveEvent">
            <input type="text" id="nameEvent" name="nameEvent" placeholder="nom">
            <textarea id="description" name="description" placeholder="description"></textarea>
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="nbPlaces">
            <input type="text" id="dateDebut" name="dateDebut" placeholder="dateDebut">
            <input type="text" id="dateFin" name="dateFin" placeholder="dateFin">

            <input type="submit" value="Enregistrer">
        </form>
    </fieldset>
<?php $articleContent = ob_get_clean();


require('View/template.php');
