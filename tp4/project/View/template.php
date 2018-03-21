<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Eveneo - <?= $pageName ?></title><!--htmlspecialchar sur chaque '< ?='-->
        <link href="style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <menu id="ariane"><!--afficher en ligne-->
            <?= $menuContent ?>
        </menu>
        
        <header>
            <div>
                <?= $_SESSION['rankFR'].' : '.$_SESSION['login'] ?>
                <form method="post" action="index.php?action=logout">
                    <input type="submit" value="Déconnexion">
                </form>
            </div>
        </header>

        <section>
            <fieldset><legend><?= $legendContent ?></legend>
                <aside>
                    <?= $asideContent ?>
                </aside>

                <article>
                    <?= $articleContent ?>
                </article>
            </fieldset>
        </section>

        <footer>
        </footer>
    </body>
</html>