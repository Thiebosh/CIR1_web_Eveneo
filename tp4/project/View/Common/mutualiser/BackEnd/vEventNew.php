<?php 
$pageName = 'Création';

$legendContent = 'Informations du nouvel événement';


ob_start(); ?>
    <li>
        <a href="index.php?action=reception"><button>Accueil</button></a>
    </li>
    <li>
        <a href="index.php?action=list&amp;date=<?= htmlspecialchars($data['date']) ?>">
            <button>Evénements du <?= htmlspecialchars($showDate) ?></button>
        </a>
    </li>
<?php $menuContent = ob_get_clean();


ob_start();
    echo "Formulaire de création d'événement";
    if (isset($data['echec'])) {
        echo "<br><br>Erreur - Certains champs sont incorrects ou manquant : ";
        foreach($data['echec'] as $message) {
            echo $message . ' ; ';
        }
        echo "<br><br>";
    }
$asideContent = ob_get_clean();


ob_start(); ?>
    <form method="post" action="index.php?action=new&amp;date=<?= htmlspecialchars($data['date']) ?>">
        <input type="text" id="name" name="name" placeholder="Titre de l'événement">
        <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Nombre de places">
        <br>
        <input type="text" id="startDate" name="startDate" placeholder="Date de début" value=<?= $data['date'] ?>><!--liste deroulante préremplie-->
        <input type="text" id="endDate"   name="endDate"   placeholder="Date de fin"   value=<?= $data['date'] ?>><!--liste deroulante-->
        <br>
        <textarea id="description" name="description" placeholder="Description de l'événement"></textarea>
        <br><br>
        <input type="hidden" name="script_new" value='true'>
        <input type="submit" value="Enregistrer">
    </form>
<?php $articleContent = ob_get_clean();


require('View/template.php');
