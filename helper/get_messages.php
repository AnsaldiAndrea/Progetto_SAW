<?php
function get_chat(){
    include('helper/connection.php');
    $stmt = $conn->prepare("SELECT distinct sender as user FROM Message WHERE receiver=? UNION SELECT distinct receiver as user FROM Message WHERE sender=?");
    $stmt->bind_param("ss", $_SESSION['username'],$_SESSION['username']);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    return NULL;
}

function get_messages($user_chat) {
    include('helper/connection.php');
    include_once('helper/functions.php');

    $result = [];
    $user=$_SESSION['username'];

    if($user_chat === $user){
        $_SESSION['error'] = ['danger',"Per quanto ne sappiamo, non sei abbastanza pazzo da parlare da solo in una chat su internet. Cerca qualcun altro con cui chattare"];
        return NULL;
    }

    $stmt = $conn->prepare("SELECT * FROM User WHERE username=?");
    $stmt->bind_param("s", $user_chat);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_array();
        if(!$result) {
            $stmt->close();
            $_SESSION['error'] = ['danger',"<strong>Nessun utente con username = $user_chat.</strong>"];
            return NULL;
        }
    }

    $stmt = $conn->prepare("SELECT * FROM Message WHERE receiver=? AND sender=? OR receiver=? AND sender=? ORDER BY send_time");
    $stmt->bind_param("ssss", $user, $user_chat, $user_chat, $user);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        if($result==NULL) $result=[];
        $now = date('Y-m-d H:i:s');
        foreach($result as $message) {
            $id = $message['id'];
            if($message['read_time']==NULL && $message['sender']!==$user) {
                $stmt = $conn->prepare("UPDATE Message SET read_time=? WHERE id=?");
                $stmt->bind_param("si", $now, $id);
                if(!$stmt->execute()) {
                    $stmt->close();
                    $_SESSION['error'] = ['danger',"Errore durante l'aggiornamento dei messaggi"];
                    return NULL;
                }
                $stmt->close();
            }
        }
        return $result;
    }
    $stmt->close();
    $_SESSION['error'] = ['danger',"Errore Insaspettato. Prova a ricaricare la pagina"];
    return NULL;
}
?>