<?php
$nbColumn = 1;
$switchPage = "<tr><th><h3>".htmlspecialchars($display)."</h3></th></tr>";

if (isset($switchName)) {
    $nbColumn = 5;
    ob_start(); ?>
        <tr>
            <th></th>
            <th>
                <a href="index.php?action=<?= $lastPage ?>">
                    <button><h3><?= htmlspecialchars($switchName) ?> précédent</h3></button>
                </a>
            </th>
            <th><h3><?= htmlspecialchars($display) ?></h3></th>
            <th>
                <a href="index.php?action=<?= $nextPage ?>">
                    <button><h3><?= htmlspecialchars($switchName) ?> suivant</h3></button>
                </a>
            </th>
            <th></th>
        </tr>
    <?php $switchPage = ob_get_clean();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Événéo - <?= htmlspecialchars($pageName) ?></title>
        <link href="View/style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <header>
            <h3><?= htmlspecialchars($_SESSION['rankFR']).' : '.htmlspecialchars($_SESSION['login']) ?></h3>
            <div class="column">
                <form method="post" action="index.php?action=logout">
                    <input type="submit" value="Déconnexion">
                </form>
                <form method="post" action="index.php?action=logout">
                    <input type="submit" value="Supprimer compte (coder)">
                </form>
            </div>
        </header>

        <menu>
            <li><span>Parcours du site :</span></li>
            <?= $menuContent ?>
        </menu>

        <section>
            <h2><?= htmlspecialchars($titleContent) ?></h2>

            <article>
                <table id="mainGrid">
                    <thead> <?= $switchPage ?> </thead>
                    <tbody>
                        <tr><td colspan=<?= htmlspecialchars($nbColumn) ?>>
                                <?= $articleContent ?>
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


<!--


#day td {
    display: flex;
    justify-content: space-between;
    width: 80%;
}
#day fieldset {
    width: 30%;
}



.tableEvents {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}




.describe {
    width: 60%;
    border-radius: 1em;
    margin: auto;
    text-align: justify;
    word-wrap: break-word;
}


-->