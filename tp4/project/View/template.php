<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Événéo - <?= htmlspecialchars($page['pageName']) ?></title>
        <link href="View/style.css" rel="stylesheet"/>
    </head>
    
    <body>
        <header>
            <?php if (isset($_SESSION['rankFR'])) { ?>
                <h3>
                    Utilisateur : <?= htmlspecialchars($_SESSION['login']) ?>
                    <br>
                    Statut : <?= htmlspecialchars($_SESSION['rankFR']) ?>
                </h3>

                <form method="post" action="index.php?action=logout">
                    <input type="submit" value="Déconnexion">
                </form>
                <!--<div>
                    <form method="post" action="index.php?action=logout">
                        <input type="submit" value="Déconnexion">
                    </form>
                    <form method="post" action="index.php?action=logout">
                        <input type="submit" value="Supprimer compte (a coder)">
                    </form>
                </div>-->
            <?php } ?>
        </header>

        <?php if (isset($_SESSION['rank'])) { ?>
            <menu>
                <li>
                    Aller au mois
                    <?php if ($page['dateMonth'] != date('Y-m') || $page['actual'] != 'month') { ?>
                        <ul>
                            <?php if ($page['dateMonth'] != date('Y-m')) { ?>
                                <li>
                                    <a href='index.php?action=month'>En cours</a>
                                </li>
                            <?php }
                            if ($page['actual'] != 'month') { ?>
                                <li>
                                    <a href="index.php?action=month&amp;date=<?= htmlspecialchars($page['dateMonth']) ?>">
                                        De navigation
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
                <li>
                    Aller au jour
                    <?php if ($page['actual'] != 'month') { ?>
                        <ul>
                            <?php if ($page['date'] != date('Y-m-d')) { ?>
                                <li>
                                    <a href='index.php?action=day&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>'>
                                        En cours
                                    </a>
                                </li>
                            <?php }
                            if ($page['actual'] != 'day') { ?>
                                <li>
                                    <a href="index.php?action=day&amp;date=<?= htmlspecialchars($page['date']) ?>">
                                        De navigation
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
                <?php if ($_SESSION['rank'] == 'ORGANIZER') { ?>
                    <li>
                        Aller à l'événement
                        <?php if ($page['actual'] != 'new' || $page['actual'] == 'edit') { ?>
                            <ul>
                                <?php if ($page['actual'] != 'new') { ?>
                                    <li>
                                        <a href="index.php?action=new&amp;date=<?= htmlspecialchars($page['dateMonth'].'-'.date('d')) ?>">
                                            Création
                                        </a>
                                    </li>
                                <?php }
                                if ($page['actual'] == 'edit') { ?>
                                    <li>
                                        <a href="index.php?action=event&amp;id=<?= htmlspecialchars($page['id']) ?>">
                                            De navigation
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </menu>
        <?php } ?>

        <section <?php if ($page['actual'] == 'login' || $page['actual'] == 'register') echo 'id="centered"'; ?>>
            <h2><?= htmlspecialchars($page['sectionTitle']) ?></h2>

            <article>
                <table id="mainGrid">
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                <?php if (isset($page['switchPage'])) { ?>
                                    <a href="index.php?action=<?= htmlspecialchars($page['actual']) ?>&amp;date=<?= htmlspecialchars($page['lastPage']) ?>">
                                        <button><h3><?= htmlspecialchars($page['switchPage']) ?> précédent</h3></button>
                                    </a>
                                <?php } ?>
                            </th>
                            <th>
                                <?php if (isset($page['mainGridTitle'])) { ?>
                                    <h3><?= htmlspecialchars($page['mainGridTitle']) ?></h3>
                                <?php } ?>
                            </th>
                            <th>
                                <?php if (isset($page['switchPage'])) { ?>
                                    <a href="index.php?action=<?= htmlspecialchars($page['actual']) ?>&amp;date=<?= htmlspecialchars($page['nextPage']) ?>">
                                        <button><h3><?= htmlspecialchars($page['switchPage']) ?> suivant</h3></button>
                                    </a>
                                <?php } ?>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="5">
                            <?= $template['article'] ?>
                        </td></tr>
                    </tbody>
                </table>
            </article>

            <a href="#"><button><h4>Haut de page</h4></button></a>
        </section>
    </body>
</html>
