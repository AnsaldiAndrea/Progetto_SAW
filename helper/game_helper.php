<?php

function get_default_new_games(){
    include('helper/connection.php');
    $result = [];
    $stmt = $conn->prepare("SELECT * FROM Game WHERE status=1 ORDER BY date DESC LIMIT 5");
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
    return $result;
}

function get_new_games() {
    include('helper/connection.php');
    $result = [];
    if(isset($_SESSION['logged_in'])){
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT tag FROM UserTags where user=?");
        $stmt->bind_param("s", $username);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $tags = [];
            while ($tag = $result->fetch_array(MYSQLI_NUM)) $tags[] = $tag[0];
            $stmt->close();
            if(!$tags) return get_default_new_games();
            $stmt = $conn->prepare("SELECT distinct id FROM Game join GameTags on Game.id=GameTags.game_id WHERE status=1 and tag in (".implode(',',$tags).")");
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $games = [];
                while ($game = $result->fetch_array(MYSQLI_NUM)) $games[] = $game[0];
                $stmt->close();
                if(!$games) return get_default_new_games();
                $stmt = $conn->prepare("SELECT * FROM Game WHERE status=1 and id in (".implode(',',$games).") ORDER BY date DESC LIMIT 5");
                if($stmt->execute()) {
                    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $stmt->close();
                    if($result) return $result;
                }
            }
        }
    }
    return get_default_new_games();
}


function get_partita($id) {
    include_once('helper/connection.php');
    $stmt = $conn->prepare("SELECT * FROM Game WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        $now = date('Y-m-d H:i:s');
        if($result['status'] ===1 and $result['date']<$now){
            $stmt = $conn->prepare("UPDATE Game SET status = 0 where id=?");
            $stmt->bind_param("i", $result['id']);
            $stmt->execute();
            $result['status'] = 0;
        }
        return $result;
    }
    return null;
}

function userGames($username) {
    include("helper/connection.php");
    $stmt = $conn->prepare("SELECT * FROM Game WHERE host=?");
    $stmt->bind_param("s", $username);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $now = date('Y-m-d H:i:s');
        foreach($result as $game) {
            if($game['status'] ===1 and $game['date']<$now){
                $stmt = $conn->prepare("UPDATE Game SET status = 0 where id=?");
                $stmt->bind_param("i", $game['id']);
                $stmt->execute();
                $game['status'] = 0;
            }
        }
        return $result;
    }
}
    
?>