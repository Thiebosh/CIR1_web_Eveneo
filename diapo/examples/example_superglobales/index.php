<?php
session_start();
if (!isset($_SESSION[date('d/m/Y h:i:s')])) {
	setcookie(date('d-m-YTh:i:s'), 'valeur', time() + 60 * 60);
	$_SESSION[date('d/m/Y h:i:s')] = 'in session';
}
?>
<html>
    <head>
        <title>Détail des superglobales</title>
    </head>
    <body>
<h1><code>$_SERVER</code></h1>
<table>
    <thead>
        <tr><th>Clé</th><th>Valeur</th></tr>
    </thead>
    <tbody>
<?php
foreach($_SERVER as $key => $value) {
?>
<tr>
    <td><?= $key ?></td>
    <td><?= htmlspecialchars($value); ?></td>
</tr>
<?php
}
?>
</table>

<h1><code>$_GET</code></h1>
<table>
    <thead>   
        <tr><th>Clé</th><th>Valeur</th></tr>
    </thead>
    <tbody>
<?php
foreach($_GET as $key => $value) {
?>
<tr>
    <td><?= $key ?></td>
    <td><?= htmlspecialchars($value);?></td>
</tr>
<?php
}
?>
</table>

<h1><code>$_COOKIE</code></h1>
<table>
    <thead>   
        <tr><th>Clé</th><th>Valeur</th></tr>
    </thead>
    <tbody>
<?php
foreach($_COOKIE as $key => $value) {
?>
<tr>
    <td><?= $key ?></td>
    <td><?= htmlspecialchars($value);?></td>
</tr>
<?php
}
?>
</table>

<h1><code>$_SESSION</code></h1>
<table>
    <thead>   
        <tr><th>Clé</th><th>Valeur</th></tr>
    </thead>
    <tbody>
<?php
foreach($_SESSION as $key => $value) {
?>
<tr>
    <td><?= $key ?></td>
    <td><?= htmlspecialchars($value);?></td>
</tr>
<?php
}
?>
</table>
    </body>
</html>
