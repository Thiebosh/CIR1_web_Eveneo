<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title><?= $title ?></title>
        <link href="style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <header>
            <?= $headerContent ?>
        </header>

        <menu id="ariane"><!--afficher en ligne-->
            <?= $menuContent ?>

            <li id="logout">
                <form method="post" action="index.php?action=logout">
                    <input type="submit" value="Déconnexion">
                </form>
            </li>
        </menu>

        <section>
            <aside>
                <?= $asideContent ?>
            </aside>

            <article>
                <?= $articleContent ?>
            </article>
        </section>

        <footer>
        </footer>
    </body>
</html>