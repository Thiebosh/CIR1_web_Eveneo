<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>page de connexion</title>
  <!--<link rel="stylesheet" href="bibliothèque.css" type="text/css"/>-->
</head>

<body>
    <header>
        <h1>NOM DU SITE</h1><!--modifier-->
    </header>

    <menu>
        <li>
            <a href="menu.html">Retours au menu</a><!--modifier-->
        </li>
    </menu>

    <section>
        <fieldset><legend>Connexion</legend>
            <form method="post" action="menu.html"><!--modifier-->
                <input type="text" id="login" name="login" placeholder="Identifiant">
                <input type="password" id="password" name="password" placeholder="Mot de passe">
                <input type="submit" value="Se connecter">
            </form>
        </fieldset>
    </section>
</body>