<?php 
include("connection.php");
include("functions.php");

if(!check_value('game_id') || !check_value('user')){
    die("errore nella richieta");
}

$game_id = intval($_POST['game_id']);
$user = sanitize($conn, $_POST['user']);

$stmt = $conn->prepare("INSERT INTO Request (game_id, user) values(?,?)");
$stmt->bind_param("is", $game_id, $user);
if($stmt->execute()) {
    print_r(json_encode(array("result"=>"OK", "game_id"=>$game_id, "user"=>$user)));
} else {
    if($conn->errno === 1062) die("Hai già inviato una richiesta per questa partita");
    die("Errore durnate l'inserimento: ".$conn->errno);
}
?>