<?php

session_start();

mysqli_report(MYSQLI_REPORT_ALL);

include('helper/connection.php');
include('helper/functions.php');
$errore = array();

if (!check_value('titolo')) {
    array_push($errore, "Il titolo non può essere vuoto");
}
if (!check_value('partecipanti')) {
    array_push($errore, "Il campo partecipanti non può essere vuoto");
} else {
    if(!($part = intval($_POST['partecipanti']))){
        array_push($errore, "Il campo Numero Partecipanti non ha il formato corretto");        
    }
}
if (!check_value('data')) {
    array_push($errore, "Il campo data non può essere vuoto");
} else {
    if(!($data = strtotime(str_replace('/', '-', $_POST['data'])))) {
        array_push($errore, "Il campo Data non ha il formato corretto");        
    }
}
if (check_value('address_error')) {
    array_push($errore, "L'indirizzo inserito non è valido");
}
if(!check_value('address') || !check_value('lat') || !check_value('lng')) {
    array_push($errore, "Errore nel caricamento della mappa. Riprova");
}
if (!check_value('descrizione')) {
    array_push($errore, "Il campo descrizione non può essere vuoto");
}
if(!check_value('tags')) {
    array_push($errore, "Almeno un tag deve essere selezionato");
} else {
    if(!is_array($_POST['tags'])){
        array_push($errore, "Il campo Tags non ha il formato corretto");
    } else {    
        $tags = $_POST['tags'];
        foreach($tags as $t){
            if(!($temp = intval($t))) {
                array_push($errore, "Una o più tag non hanno il formato corretto");
            }
        }
    }
}

if (empty($errore)) {
    $titolo = sanitize($conn,$_POST['titolo']);
    $data = strtotime(str_replace('/', '-', $_POST['data']));
    $data_db = date('Y-m-d H:i', $data);
    $part = intval($_POST['partecipanti']);
    $host = $_SESSION['username'];
    $comm = sanitize($conn,$_POST['descrizione']);
    $address = sanitize($conn,$_POST['address']);
    $lat = doubleval(sanitize($conn,$_POST['lat']));
    $lng = doubleval(sanitize($conn,$_POST['lng']));
    $tags = $_POST['tags'];
    $stmt = $conn->prepare("INSERT INTO Game (game, host, address, lat, lng, n_player, comment, date) values(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssddiss", $titolo, $host, $address, $lat, $lng, $part, $comm, $data_db);
    if($stmt->execute()) {
        $game_id = $conn->insert_id;
        $stmt_tag = $conn->prepare("INSERT INTO GameTags values(?,?)");
        foreach($tags as $t) {
            $tag = intval($t);
            $stmt_tag->bind_param("ii", $game_id, $tag);
            $stmt_tag->execute();
        }    
        $stmt->close();
        $_SESSION['error'] = ['success', 'Partita creata con successo'];
        header("Location: partita.php?id=$game_id");
        exit();
    } else {
        $stmt->close();
        $_SESSION['error'] = ['danger', "Errore durante l'inserimento: ".$stmt->error];
        header('Location: creapartita.php');
        exit();
    }
} else {
    $error_string = "Errore:";
    foreach($errore as $e) {
        $error_string = $error_string."<br>- ".$e;
    }
    $_SESSION['error'] = ["danger", $error_string];
    header('Location: creapartita.php');
    exit();
}
$conn->close();
?>
