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
                <h2><?php echo $produit['nom'] ?></h2>
                <img src="./images/<?php $produit['img'] ?>" alt="miniature produit"><br>
                Prix : <?php $produit['prix'] ?><br>
                Articles disponibles : <?php $produit['nbArticle'] ?>
            </article>
        <?php  }   ?>
        
        
        <a href='index.php?page=ajout'>ajouter un produit</a>
    </section>
	
</body>
</html>
