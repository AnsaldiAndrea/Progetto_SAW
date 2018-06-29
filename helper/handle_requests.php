<?php 
session_start();
include("connection.php");
include("functions.php");

if(!check_value('game_id') || !check_value('user') || !check_value('action')){
    die("errore nella richiesta");
}

$game_id = intval($_POST['game_id']);
$user = sanitize($conn, $_POST['user']);
if(!$_POST['action'] === 'accept' or !$_POST['action'] === 'deny') 
    die("Impossibile effettuare la richista");  
$status = $_POST['action'] === 'accept'? 1:-1;

$stmt = $conn->prepare("SELECT * FROM Request join Game on Game.id=Request.game_id where host=? and id=? and user=?");
$stmt->bind_param("sis",$_SESSION['username'],$game_id, $user);
if($stmt->execute()){
    if(!$stmt->get_result()->fetch_array(MYSQLI_NUM)) 
        die("Impossibile effettuare la richista: ".$stmt->error);  
}

$stmt = $conn->prepare("UPDATE Request set status=$status where game_id=? and user=?");
$stmt->bind_param("is", $game_id, $user);
if($stmt->execute()) {
    print_r(json_encode(array("result"=>"OK", "game_id"=>$game_id, "user"=>$user, "status"=>$status)));
} else {
    die("Errore durnate l'aggiornamento: ".$stmt->error);
}
?>