<?php
ob_start(); ?>
    <fieldset>
        <legend>Formulaire de <?= htmlspecialchars($page['switch']) ?> d'événement</legend>
        <form method="post" action="index.php?action=edit&amp;<?= htmlspecialchars($page['getForm'][0]) ?>=<?= htmlspecialchars($page['getForm'][1]) ?>">
            <table>
                <tr>
                    <td><label>Titre de l'événement : </label></td>
                    <td><input type="text" id="name" name="name" placeholder="Titre" value=<?= htmlspecialchars($page['name']) ?>></td>
                </tr>
                <tr>
                    <td><label>Nombre de places <?php htmlspecialchars($page['editPlace']) ?> : </label></td>
                    <td><input type="text" id="nbPlaces" name="nbPlaces" placeholder="Places" value=<?= htmlspecialchars($page['place']) ?>></td>
                </tr>
                <tr>
                    <td><label>Début de l'événement : </label></td>
                    <td>
                        <input type="date" id="startDate" name="startDate" value=<?= htmlspecialchars($page['startDate']) ?> min=<?= htmlspecialchars($page['startDate']) ?>>
                        <input type="time" id="startTime" name="startTime" value=<?= htmlspecialchars($page['startTime']) ?> min="00:00" max="23:59">
                    </td>
                </tr>
                <tr>
                    <td><label>Fin de l'événement : </label></td>
                    <td>
                        <input type="date" id="endDate" name="endDate" value=<?= htmlspecialchars($page['endDate']) ?> min=<?= htmlspecialchars($page['startDate']) ?>>
                        <input type="time" id="endTime" name="endTime" value=<?= htmlspecialchars($page['endTime']) ?> min="00:00" max="23:59">
                    </td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="2"><label>Description de l'événement : </label></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea id="description" name="description" placeholder="Description"><?= htmlspecialchars($page['description']) ?></textarea></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="script" value='edit'>
            <input type="submit" value="Enregistrer">
        </form>
    </fieldset>
<?php $template['article'] = ob_get_clean();


require('View/template.php');
