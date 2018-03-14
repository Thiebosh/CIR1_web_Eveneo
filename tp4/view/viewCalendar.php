<!doctype html>
<html lang="fr">
    <head>
        <title>Une collision... | Sciences-info geek</title>
        <meta charset="UTF-8">
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
        <?php
        if ($_SESSION['rank'] == "CUSTOMER") {
            include('partCustomer.php');
        }
        else {
            include('partOrganizer.php');
        }
        ?>

        <!--modifier en boutons cliquables, mettre en bandeau pied de page avec css-->
        <fieldset><legend>Changer de mois</legend>
            <form method="post" action="menu.html"><!--modifier-->
                <input type="submit" value="Voir le mois précédent">
            </form>

            <form method="post" action="menu.html"><!--modifier-->
                <input type="submit" value="Voir le mois suivant">
            </form>
        </fieldset>
    </section>
    
    <footer>
    </footer>
</body>

</html>
