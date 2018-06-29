<?php

session_start();

include('helper/functions.php');
include('helper/connection.php');

$errore = array();

if (!check_value('nome')) {
    array_push($errore, "Il nome non può essere vuoto");
}elseif(preg_match('~[0-9]~', $_POST['nome'])===1){
    array_push($errore, "Il nome non può contenere numeri");
}
if (!check_value('genere')) {
    array_push($errore, "Seleziona un genere!");
}
if (!check_value('eta')) {
    array_push($errore, "Il campo data non può essere vuoto");
}
if (!check_value('indirizzo')) {
    array_push($errore, "Il campo indirizzo non può essere vuoto");
} else {
    if (check_value('address_error')) {
        array_push($errore, "L'indirizzo inserito non è valido");
    } else {
        if(!check_value('address') || !check_value('lat') || !check_value('lng')) {
            array_push($errore, "Errore Inaspettato. Riprova");
        }
    }
}
if (!check_value('email')) {
    array_push($errore, "Il campo mail non può essere vuoto");
}
if (!check_value('username')) {
    array_push($errore, "Il campo username non può essere vuoto");
} elseif(preg_match("/^[a-zA-Z0-9_-.]*$/", $_GET['username'])!==1) {
    array_push($errore, "Il campo username può contenere solo lettere, numeri, underscore, trattini e punti");    
}

if (!check_value('password')) {
    array_push($errore, "Il campo password non può essere vuoto");
}
if (!check_value('conferma_password')) {
    array_push($errore, "Il campo conferma password non può essere vuoto");
} elseif ($_POST['password'] != $_POST['conferma_password']) {
    array_push($errore, " La Password e Conferma Password non hanno lo stesso valore");
}
if(strlen($_POST['password'])<8){
    array_push($errore, "La password deve contenere almeno otto caratteri");
}
if(preg_match("#[0-9]+#",$_POST['password'])!==1){
    array_push($errore, "La password deve contenere almeno un numero");
}
if(preg_match("#[a-zA-Z]+#",$_POST['password'])!==1){
    array_push($errore, "La password deve contenere almeno una lettera");
}

if (empty($errore)) {
    $nome = sanitize($conn,$_POST['nome']);
    $eta = sanitize($conn,$_POST['eta']);
    $email = sanitize($conn,$_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $address = sanitize($conn,$_POST['address']);
    $lat = doubleval(sanitize($conn,$_POST['lat']));
    $lng = doubleval(sanitize($conn,$_POST['lng']));

    $genere = $_POST['genere'];
    $username = sanitize($conn,$_POST['username']);
    $password_encoded = password_hash(sanitize($conn, $_POST['password']), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO User (name, age, address, email, username, password, lat, lng, gender) values(?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sissssdds", $nome, $eta, $address, $email, $username, $password_encoded, $lat, $lng, $genere);
    if($stmt->execute()) {
        $_SESSION['logged_in'] = TRUE;
        $_SESSION['username'] = $username;    
        $_SESSION['name'] = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;
        $_SESSION['lat'] = $lat;
        $_SESSION['lat'] = $lng;
        $_SESSION['age'] = $eta;
        if($genere === 'm') $_SESSION['gender'] = "M";
        if($genere === 'f') $_SESSION['gender'] = "F";
        if($genere === 'a') $_SESSION['gender'] = "Altro";
        $_SESSION['error'] = ['success', "Iscrizione avvenuta con successo.<br>Benvenuto $nome"];
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = ["danger", "Errore durante l'inserimento!: ".$stmt->error];
        header('Location: iscrizione.php');
        exit();
    }
    $stmt->close();
} else {
    $error_string = "Errore:";
    foreach($errore as $e) {
        $error_string = $error_string."<br>- ".$e;
    }
    $_SESSION['error'] = ["danger", $error_string];
    header('Location: iscrizione.php');
    exit();
}
$conn->close();
?>
