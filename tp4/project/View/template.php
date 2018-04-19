<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Événéo - <?= htmlspecialchars($page['pageName']) ?></title>
        <link href="View/style.css" rel="stylesheet"/>
    </head>
    
    <body>
        <?php if (isset($_SESSION['rank'])) { ?>
            <header>
                <aside class="account">
                    <h3>
                        Utilisateur : <?= htmlspecialchars($_SESSION['login']) ?>
                        <br>
                        Statut : <?= htmlspecialchars($_SESSION['rankFR']) ?>
                    </h3>
                    <br>
                    <form method="post" action="index.php?action=logout">
                        <input type="submit" value="Suppression (coder)">
                    </form>
                    <form method="post" action="index.php?action=logout">
                        <input type="submit" value="Déconnexion">
                    </form>
                </aside>

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
                        <?php //only one evaluation
                        $firstCond = $secondCond = false;
                        if (!($page['startDate'] == date('Y-m-d') && $page['actual'] == 'day')) $firstCond = true;
                        if ($page['actual'] != 'month' && $page['actual'] != 'day') $secondCond = true;

                        if ($firstCond || $secondCond) { ?>
                            <ul>
                                <?php if ($firstCond) { ?>
                                    <li>
                                        <a href='index.php?action=day&amp;date=<?= htmlspecialchars(date('Y-m-d')) ?>'>
                                            En cours
                                        </a>
                                    </li>
                                <?php }
                                if ($secondCond) { ?>
                                    <li>
                                        <a href="index.php?action=day&amp;date=<?= htmlspecialchars($page['startDate']) ?>">
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
                                            <a href="index.php?action=edit&amp;date=<?= htmlspecialchars($page['dateMonth'].date('-d')) ?>">
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

                <aside class="alert">
                    
                    <li>
                        <h3>(coder)Notification</h3>
                        <ul>
                            <li>
                                <?php if (isset($listNotice)) {
                                    echo 'Certains champs sont incorrects ou manquant : ';
                                    foreach($listNotice as $message) echo '<br>'.htmlspecialchars($message);
                                }
                                else echo 'Pas de notif'; ?>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h3>(finir)Alertes</h3>
                        <ul>
                            <li>
                                <?php if (isset($listWarning)) {
                                    echo 'Certains champs sont incorrects ou manquant : ';
                                    foreach($listWarning as $message) echo '<br>- '.htmlspecialchars($message);
                                }
                                else echo 'Pas d\'alerte';?>
                            </li>
                        </ul>
                    </li>
                </aside>
            </header>
        <?php } ?>

            

        <section <?php if ($page['actual'] == 'login' || $page['actual'] == 'register') echo 'id="centered"'; ?>>
            <h2><?php
                if ($page['actual'] == 'month' || $page['actual'] == 'month') echo 'Évènements du '.htmlspecialchars(lcfirst($page['pageName']));
                else echo htmlspecialchars($page['pageName']);
                if ($page['actual'] == 'event' || $page['actual'] == 'edit') echo ' de l\'événement';
            ?></h2>

            <article>
                <table id="mainGrid">
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                <?php if (isset($page['lastPage'])) { ?>
                                    <a href="index.php?action=<?= htmlspecialchars($page['actual']) ?>&amp;date=<?= htmlspecialchars($page['lastPage']) ?>">
                                        <button><h3><?= htmlspecialchars($page['pageName']) ?> précédent</h3></button>
                                    </a>
                                <?php } ?>
                            </th>
                            <th>
                                <?php if (isset($page['mainGridTitle'])) { ?>
                                    <h3><?= htmlspecialchars(ucfirst($page['mainGridTitle'])) ?></h3>
                                <?php } ?>
                            </th>
                            <th>
                                <?php if (isset($page['nextPage'])) { ?>
                                    <a href="index.php?action=<?= htmlspecialchars($page['actual']) ?>&amp;date=<?= htmlspecialchars($page['nextPage']) ?>">
                                        <button><h3><?= htmlspecialchars($page['pageName']) ?> suivant</h3></button>
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
