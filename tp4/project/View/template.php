<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Eveneo - <?= htmlspecialchars($pageName) ?></title>
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
            <?= $menuContent ?>
        </menu>

        <section>
            <fieldset>
                <legend>
                    <h2><?= htmlspecialchars($legendContent) ?></h2>
                </legend>

                <article>
                    <?= $articleContent ?>
                </article>

                <aside>
                    <?= $asideContent ?>
                </aside>
            </fieldset>
        </section>
    </body>
</html>