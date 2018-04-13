<html>
<head>
	<meta charset="utf-8">
    <title>Page d'ajout de produits</title>
</head>
<body>
    <section>
        <h1>Ajoutez votre article</h1>

        <form action="index.php?page=affiche" method="POST" enctype="multipart/form-data">
            <fieldset id="identity">
                <!-- synchroniser id et for, a minima  -->
                <p>
                    <label for="nom">Nom du produit : </label>
                    <input type="text" name="nom" id="nom"/>
                </p>
                <p>
                    <label for="nom">Prix : </label>
                    <input type="number" min="0" name="prix" id="prix"/>
                </p>
                <p>
                    <label for="nom">Nombre d'articles en stock : </label>
                    <input type="number" min="0" name="stock" id="stock"/>
                </p>
                <p>
                    <label for="nom">Image du produit : </label>
                    <input type="file" name="photo" id="photo"/>
                </p>
            </fieldset>
            <p>
                <input type="submit" value="Send"/>
            </p>
        </form>

    </section>
	
</body>
</html>
