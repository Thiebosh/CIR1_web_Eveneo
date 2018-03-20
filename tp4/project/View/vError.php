<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Eveneo - <?= $pageName ?></title>
        <link href="style.css" rel="stylesheet"/>
    </head>
        
    <body>
        <fieldset><legend>Erreur</legend>
            <?= htmlspecialchars($errorMessage) ?>
        </fieldset>
    </body>
</html>