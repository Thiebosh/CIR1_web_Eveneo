<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Eveneo - <?= $pageName ?></title>
        <link href="style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <fieldset><legend>Erreur</legend>
            <p>
                <?= htmlspecialchars($errorMessage) ?>
            </p>
            <a href="index.php?ation=<?= $redirection['link'] ?>">
                Retours à <?= $redirection['text'] ?><br>
            </a>
        </fieldset>
    </body>
</html>