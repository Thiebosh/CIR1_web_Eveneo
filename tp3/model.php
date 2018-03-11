<?php
function connectToDb($ini_array) {
    try {
        $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $bdd = new PDO($ini_array['db']['dsn'], $ini_array['db']['user'], $ini_array['db']['pass'], $opts);
    } catch (Exception $e) {
        exit('Erreur de connexion à la base de données.' . $e->getMessage());
    }
    return $bdd;
}

function insertMessage(PDO $bdd, $pseudo, $message) {
    $date = date('Y-m-d H:i:s');
    $query = 'INSERT INTO messages(pseudo, message, date) VALUES(?, ?, ?)';
    $prepared = $bdd->prepare($query);
    if ($prepared->execute([$pseudo, $message, $date])) {
        return true;
    }
    return false;
}

function getPageOfMessages(PDO $bdd, int $nbPerPage, int $page): array {
    $query = 'SELECT pseudo, message, date FROM messages ORDER BY date ASC LIMIT :nb OFFSET :skip';
    $prepared = $bdd->prepare($query);
    $prepared->bindValue(':nb', $nbPerPage);
    $prepared->bindValue(':skip', $nbPerPage * ($page - 1));
    $prepared->execute();
    return $prepared->fetchAll(PDO::FETCH_ASSOC);
}

function moderatePseudo(PDO $bdd, $pseudo, $replacementMessage) {
    $query = 'UPDATE messages SET message=:replacement WHERE pseudo=:pseudo';
    $prepared = $bdd->prepare($query);
    $prepared->execute([
        'replacement' => $replacementMessage,
        'pseudo' => $pseudo
    ]);
}

function getNbPages(PDO $bdd, $nbPerPages) {
    $count = $bdd->query('SELECT COUNT(*) as c FROM messages').fetchAll()[0]['c'];
    return ceil($count / $nbPerPages);
}