<html>
<head>
	<meta charset="utf-8">
    <title>Page d'ajout de produits</title>
</head>
<body>
    <section>
        <h1>Liste des articles</h1>

        <?php   foreach($listeProduits as $produit) {  ?><!--utilisation correcte??-->
            <article>
                <h2><?php echo '$listeProduits[$nom]' ?></h2>
                <img src="./images/<?php $listeProduits[$img] ?>" alt="miniature produit"><br>
                Prix : <?php $listeProduits[$prix] ?><br>
                Articles disponibles : <?php $listeProduits[$nbArticle] ?>
            </article>
        <?php  }   ?>
        
        
        <a href='index.php?page=ajout'>ajouter un produit</a>
    </section>
	
</body>
</html>
