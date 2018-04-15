<?php 
ob_start(); ?>
    <div>
        <?php 
        if (isset($dataPage['echec'])) {
            echo "<br><br>Erreur - Certains champs sont incorrects ou manquant : ";
            foreach($dataPage['echec'] as $message) {
                echo htmlspecialchars($message) . ' ; ';
            }
        }
        ?>
    </div>
    <fieldset>
        <legend>Formulaire de création</legend>
        <form method="post" action="index.php?action=new&amp;date=<?= htmlspecialchars($page['date']) ?>">
            <label>Titre de l'événement : </label><label>Nombre de places : </label><br>
            <input type="text" id="name" name="name" placeholder="Titre">
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Places">
            <br>
            <label>Date de début : </label><label>Date de fin : </label><br>
            <input type="text" id="startDate" name="startDate" placeholder="Date de début" value=<?= htmlspecialchars($page['date']) ?>><!--liste deroulante préremplie-->
            <input type="text" id="endDate"   name="endDate"   placeholder="Date de fin"   value=<?= htmlspecialchars($page['date']) ?>><!--liste deroulante-->
            <br>
            <label>Description de l'événement : </label><br>
            <textarea id="description" name="description" placeholder="Description"></textarea>
            <br><br>
            <input type="hidden" name="script_new" value='true'>
            <input type="submit" value="Enregistrer">
        </form>
    </fieldset>
<?php $template['article'] = ob_get_clean();


require('View/template.php');

/*
<select name="choix">

    <option value="choix1">Choix 1</option>

    <option value="choix2">Choix 2</option>

    <option value="choix3" selected="selected">Choix 3</option>

    <option value="choix4">Choix 4</option>

</select>
*/
