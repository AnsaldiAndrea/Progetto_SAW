<?php
include('helper/connection.php');
include('helper/functions.php');

session_start();

$username=$_SESSION['username'];
if (check_value('email')){
    $email=sanitize($conn,$_POST['email']);
    $stmt = $conn->prepare("UPDATE User SET email=? where username=?");
    $stmt->bind_param("ss", $email, $username);
    if($stmt->execute()) {
        $_SESSION['email'] = $email;
    } else {
        $stmt->close();
        $_SESSION['error']= ['danger', "Errore durante l'aggiornamento. Riprova"];
        header("Location: modificaprofilo.php");
        exit();
    }
}

if (check_value('eta')){
    $age=intval(sanitize($conn,$_POST['eta']));
    $stmt = $conn->prepare("UPDATE User SET age=? where username=?");
    $stmt->bind_param("is", $age, $username);
    if($stmt->execute()) {
        $_SESSION['age'] = $age;
    } else {
        $stmt->close();
        $_SESSION['error']= ['danger', "Errore durante l'aggiornamento. Riprova"];
        header("Location: modificaprofilo.php");
        exit();
    }
}
echo("test");
if (check_value('password') and check_value('conferma_password') and $_POST['password']===$_POST['conferma_password']){
    echo("test");
    if(strlen($_POST['password'])<8 or preg_match("#[0-9]+#",$_POST['password'])!==1 or preg_match("#[a-zA-Z]+#",$_POST['password'])!==1){
        echo("test");
        $_SESSION['error'] = ['danger', "La password deve contenere almeno otto caratteri, deve contenere almeno un numero e aleno una lettera"];
        header('Location: modificaprofilo.php');
        exit();
    }
    $password_encoded = password_hash(sanitize($conn, $_POST['password']), PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE User SET password=? where username=?");
    $stmt->bind_param("ss", $password_encoded, $username);
    if(!$stmt->execute()) {
        $stmt->close();
        $_SESSION['error']= ['danger', "Errore durante l'aggiornamento. Riprova"];
        header("Location: modificaprofilo.php");
        exit();
    }
}

if(check_value('indirizzo')){
    if(check_value('address') and check_value('lat') and check_value('lng')) {
        $address = sanitize($conn,$_POST['address']);
        $lat = doubleval(sanitize($conn,$_POST['lat']));
        $lng = doubleval(sanitize($conn,$_POST['lng']));        
        $stmt = $conn->prepare("UPDATE User SET address=?, lat=?, lng=? where username=?");
        $stmt->bind_param("sdds", $address, $lat, $lng, $username);
        if($stmt->execute()) {
            $_SESSION['address'] = $address;
            $_SESSION['lat'] = $lat;
            $_SESSION['lat'] = $lng;
        } else {
            $stmt->close();
            $_SESSION['error']= ['danger', "Errore durante l'aggiornamento. Riprova"];
            header("Location: modificaprofilo.php");
            exit();
        }
    }    
}


if(check_value('tags')) {
    if(!is_array($_POST['tags'])){
        $_SESSION['error']= ['danger', "Formato Richiesta Incorretto"];
        header("Location: modificaprofilo.php");
        exit();
    } else {
        $tags = $_POST['tags'];
        $stmt = $conn->prepare("DELETE FROM UserTags where user=?");
        $stmt->bind_param("s", $username);
        if($stmt->execute()){
            $stmt_tag = $conn->prepare("INSERT INTO UserTags values(?,?)");
            foreach($tags as $t){
                if(!($tag = intval($t))) {
                    $_SESSION['error']= ['danger', "Una o più tag non hanno il formato corretto"];
                    header("Location: modificaprofilo.php");
                    exit();
                }
                $stmt_tag->bind_param("si", $username, $tag);
                $stmt_tag->execute();
            }
            $stmt_tag->close();
        } else {
            $_SESSION['error']= ['danger', "Errore durante l'aggiornamento. Riprova"];
            header("Location: modificaprofilo.php");
            exit();
        }
        $stmt->close();
    }
}

$conn->close();

$_SESSION['error'] = ['success', "Modifiche effettuate con successo"];
header("Location: profilo.php");
exit();
?>