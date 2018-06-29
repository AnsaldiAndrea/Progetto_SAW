<?php 
session_start();
include('helper/connection.php');
include('helper/functions.php');

if(check_value('message') and check_value('receiver')) {
    $message = sanitize($conn,$_POST['message']);
    $user= $_SESSION['username'];
    $date = date('Y-m-d H:i:s');
    $receiver = sanitize($conn,$_POST['receiver']);
    $stmt = $conn->prepare("INSERT into Message (sender,receiver,message,send_time) values(?,?,?,?)");
    $stmt->bind_param("ssss", $user, $receiver, $message, $date);
    if($stmt->execute() and $stmt->affected_rows===1){
        echo($stmt->affected_rows);
        header("Location: chat.php?user=".base64_encode($receiver));
        exit();
    }
    else {
        $_SESSION['error'] = ['danger', "Errore durante l'invio del messaggio. Riprova: ".$stmt->error];
        header("Location: chat.php?user=".base64_encode($receiver));
        exit();
    }
}
$_SESSION['error'] = ['danger', "Richista non valida"];
header("Location: chat.php");
exit();
?>