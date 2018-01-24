<html>
<head>
	<meta charset="utf-8">
    <title>Page d'ajout de produits</title>
</head>
<body>

    <form action="index.php?page=affiche" method="POST" enctype="multipart/form-data">
        <fieldset id="identity">
            <!-- synchroniser id et for, a minima  -->
            <p>
                <input type="text" name="nom" id="nom"/><label for="nom">Prénom</label>
            </p>
            <p>
                <input type="text" name="prix" id="prix"/><label for="prix">Nom</label>
            </p>
            <p>
                <input type="text" name="stock" id="stock"/><label for="stock">Nom</label>
            </p>
            <p>
                <input type="file" name="photo" id="photo"/><label for="photo">Photo de votre produit</label>
            </p>
        </fieldset>
        <p>
            <input type="submit" value="Send"/>
        </p>
    </form>
	
</body>
</html>
