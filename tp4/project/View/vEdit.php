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
        <legend>Formulaire d'édition</legend>
        <form method="post" action="index.php?action=edit&amp;id=<?= htmlspecialchars($page['id']) ?>">
            <label>Nouveau titre : </label><label>Nouveau nombre de places restantes : </label><br>
            <input type="text" id="name" name="name" placeholder="Titre" value=<?= htmlspecialchars($page['name']) ?>>
            <input type="text" id="nbPlaces" name="nbPlaces" placeholder="Places" value=<?= htmlspecialchars($page['place']) ?>>
            <br>
            <label>Nouvelle date de fin : </label><br>
            <input type="text" id="endDate" name="endDate" placeholder="Date de fin" value=<?= htmlspecialchars($page['enddate']) ?>><!--liste deroulante preremplie-->
            <br>
            <br>
            <label>Nouvelle description : </label><br>
            <textarea id="description" name="description" placeholder="Description"><?= $page['description'] ?></textarea><!--lui appliquer htmlspecialchar le detruit-->
            <br>
            <br>
            <input type="hidden" name="startDate" value=<?= htmlspecialchars($page['startdate']) ?>>
            <input type="hidden" name="script_edit" value='true'>
            <input type="submit" value="Modifier">
        </form>
    </fieldset>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
