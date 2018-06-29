<?php 
session_start();
include("connection.php");
include("functions.php");

if(!check_value('game_id') || !check_value('user')){
    die("errore nella richiesta");
}

$game_id = intval($_POST['game_id']);
$user = sanitize($conn, $_POST['user']);

if($user !== $_SESSION['username']) {
    die("Impossibile effettuare la richista");
}

$stmt = $conn->prepare("DELETE FROM Request WHERE game_id=? and user=?");
$stmt->bind_param("is", $game_id, $user);
if($stmt->execute()) {
    print_r(json_encode(array("result"=>"OK", "game_id"=>$game_id, "user"=>$user)));
} else {
    die("Errore durnate la cancellazione: ".$stmt->error);
}
?>