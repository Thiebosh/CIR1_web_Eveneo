<article>
    <?php
    foreach($mounth as $day) {
        echo '<div class ="day">';
        //prepare requete
        foreach($requete as $conference) {
            echo '<div class ="conference">';
            echo '<a href="viewConference.php?conferenc=$conference["id"]>' . $conference["nom"] . '</a>';
            echo '</div>';
        }
        echo '</div>';
    }

    if ($nbConf > 5) {
        ?>
        <form method="post" action="menu.html"><!--modifier-->
            <input type="submit" value="Voir plus de conférences">
        </form>
        <?php
    }
    ?>
</article>