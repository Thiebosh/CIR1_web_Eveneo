<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width" />
        <title>ChatBot</title>
    </head>

    <body>
        <form action="./" method="POST" enctype="multipart/form-data">
            <fieldset><br>
                <div>
                    <h2>ChatBot CIR 63</h2><br>
                    <fieldset>
                        <i>Connexion au réseau...</i><br>
                        <?php   messageChat($bdd); ?>
                    </fieldset><br>
                    <label for="username"></label><br>
                        <input type="text" name="username" id="username" placeholder=" Username" required/>
                    <br><br>
                    <label for="message"></label>
                        <input type="text" name="message" id="message" rows="10" cols="50" placeholder="Message"></input>
                        <input type="submit" id="sender" value="Envoyer" />
                </div>
            </fieldset>
        </form>
    </body>
</html>