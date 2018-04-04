<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Eveneo - Erreur</title>
        <link href="style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <fieldset><legend>Erreur</legend>
            <p>
                <?= htmlspecialchars($errorMessage) ?>
            </p>
            <a href="index.php?ation=<?= htmlspecialchars($redirection['link']) ?>">
                Retours à <?= htmlspecialchars($redirection['text']) ?><br>
            </a>
        </fieldset>
    </body>
</html>