<?php
session_start();
// index.php is just a "router"
if (isset($_GET['page']) && $_GET['page'] == 'ajout') {
    include('./ajouter_produit.php');
} else {
    include('./liste_produit.php');
}