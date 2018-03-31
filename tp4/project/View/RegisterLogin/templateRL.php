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
            Bienvenue sur Eveneo
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