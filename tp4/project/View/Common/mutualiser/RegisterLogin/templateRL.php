<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Eveneo - <?= htmlspecialchars($pageName) ?></title>
        <!--<link href="RLstyle.css" rel="stylesheet"/>-->
    </head>
        
    <body>
        <section>
            <fieldset><legend>Bienvenue sur Eveneo : <?= htmlspecialchars($legendContent) ?></legend>
                <br>
                <article>
                    <?= $articleContent ?>
                </article>
                <br>
                <aside>
                    <?= $asideContent ?>
                </aside>
            </fieldset>
        </section>
    </body>
</html>