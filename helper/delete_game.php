<?php 
session_start();
include("connection.php");
include("functions.php");

if(!check_value('game_id')){
    die("errore nella richiesta");
}

$game_id = intval($_POST['game_id']);
$user = $_SESSION['username'];

$stmt = $conn->prepare("DELETE FROM Game WHERE id=? and host=?");
$stmt->bind_param("is", $game_id, $user);
if($stmt->execute()) {
    $stmt->close();
    print_r(json_encode(array("result"=>"OK", "game_id"=>$game_id)));
} else {
    die("Errore durnate la cancellazione: ".$stmt->error);
}
?>