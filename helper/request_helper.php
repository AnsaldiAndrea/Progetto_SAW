<?php 
function get_received_requests($user) {
    include('helper/connection.php');
    $stmt = $conn->prepare("SELECT id, game, date, Request.status, user FROM Request JOIN Game on Request.game_id=Game.id WHERE host=?");
    $stmt->bind_param("s", $user);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    return null;
}

function get_requests_for_game($id) {
    include('helper/connection.php');
    $stmt = $conn->prepare("SELECT id, game, date, Request.status, user FROM Request JOIN Game on Request.game_id=Game.id WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    return null;
}

function get_requests($user) {
    include('helper/connection.php');
    $stmt = $conn->prepare("SELECT game_id, game, host, date, Request.status FROM Request JOIN Game on Request.game_id=Game.id WHERE user=?");
    $stmt->bind_param("s", $user);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    return null;
}


?>