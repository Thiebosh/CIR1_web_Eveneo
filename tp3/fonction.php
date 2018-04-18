<?php
function initial() {
   $bdd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', '1a9z9e8r');
   return $bdd;
}

function insertion($bdd) {
    $statement = $bdd->prepare('INSERT INTO message(username, text, post_date) VALUES(:username, :text, :post_date)');//preparation ( values pour securiser)
    $statement->execute([":username"=>$_POST['username'],":text"=>$_POST['message'],":post_date"=>date('y-M-d H:i:s')]);//injection dans table
}

function messageChat($bdd) {
    $reponse = $bdd->query('SELECT * FROM message');
    foreach ($reponse->fetchAll() as $data) {//traite chaque ligne de la bdd /\ probleme??
        
        $tab = explode(' ', $data['text']);//separe string en tab a chaque espace
        $first_string = $tab[0];
        
        if($first_string  === "/ban"){//comparaison en ajustant les types si besoin
            $username_banned = $tab[1];
            $reason = implode(' ', array_slice($tab, 2));//regroupe tabs en string et ajoute espace
            if($data['username']  === $username_banned) {
                echo 'Censuré pour : '.$reason.'<br>';
            }
        }
        else if($data['username']  === $username_banned) {
            echo 'Censuré pour : '.$reason.'<br>';
        }
        else if($first_string  === "/me") {
            echo '<i>'.$data['post_date'].' : '.$data['username'].' : '.substr($data['text'], 3).'</i><br>';//substr : teste les 3 premiers caracteres de la table
        }
        else if ($data['username']  !== $username_banned) { 
            echo $data['post_date'].' : '.$data['username'].' : '.$data['text'].'<br>';
        }
    }
}