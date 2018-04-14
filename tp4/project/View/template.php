<?php
$template['nbColumn'] = 1;
$template['switchPage'] = '<tr><th><h3>'.htmlspecialchars($template['title']).'</h3></th></tr>';

if (isset($template['switchName'])) {
    $template['nbColumn'] = 5;
    ob_start(); ?>
        <tr>
            <th></th>
            <th>
                <a href="index.php?action=<?= $template['lastPage'] ?>">
                    <button><h3><?= htmlspecialchars($template['switchName']) ?> précédent</h3></button>
                </a>
            </th>
            <th><h3><?= htmlspecialchars($template['title']) ?></h3></th>
            <th>
                <a href="index.php?action=<?= $template['nextPage'] ?>">
                    <button><h3><?= htmlspecialchars($template['switchName']) ?> suivant</h3></button>
                </a>
            </th>
            <th></th>
        </tr>
    <?php $template['switchPage'] = ob_get_clean();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Événéo - <?= htmlspecialchars($template['pageName']) ?></title>
        <link href="View/style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <header>
            <?php if (isset($_SESSION['rankFR'])) { ?>
                <h3>
                    Utilisateur : <?= htmlspecialchars($_SESSION['login']) ?>
                    <br>
                    Statut : <?= htmlspecialchars($_SESSION['rankFR']) ?>
                </h3>
                <form method="post" action="index.php?action=logout">
                    <input type="submit" value="Déconnexion">
                </form>
                <!--<div class="column">
                    <form method="post" action="index.php?action=logout">
                        <input type="submit" value="Déconnexion">
                    </form>
                    <form method="post" action="index.php?action=logout">
                        <input type="submit" value="Supprimer compte (a coder)">
                    </form>
                </div>-->
            <?php } 
            else echo '<h3>Statut : Visiteur</h3>'; ?>
        </header>

        <?= $template['menuContent'] ?>

        <section>
            <h2><?= htmlspecialchars($template['titleContent']) ?></h2>

            <article>
                <table id="mainGrid">
                    <thead> <?= $template['switchPage'] ?> </thead>
                    <tbody>
                        <tr><td colspan=<?= htmlspecialchars($template['nbColumn']) ?>>
                            <?= $template['articleContent'] ?>
                        </td></tr>
                    </tbody>
                </table>
            </article>

            <aside>
                <a href="#"><button><h4>Haut de page</h4></button></a>
            </aside>
        </section>
    </body>
</html>
