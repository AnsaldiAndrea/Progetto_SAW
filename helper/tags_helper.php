<?php

function get_user_tags() {
    include('helper/connection.php');
    if(isset($_SESSION['logged_in'])){
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT Tags.tag FROM UserTags join Tags on UserTags.tag=Tags.id where user=?");
        $stmt->bind_param("s", $username);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $tags = [];
            while ($tag = $result->fetch_array(MYSQLI_NUM)) $tags[] = $tag[0];
            $stmt->close();
            if($tags) return $tags;
        }
    }
    return ["Nessuna Tag selezionata."];
}

function get_user_tags_from_username($username){
    include('helper/connection.php');
    include_once('helper/functions.php');
    $username = sanitize($conn, $username);
    $stmt = $conn->prepare("SELECT Tags.tag FROM UserTags join Tags on UserTags.tag=Tags.id where user=?");
    $stmt->bind_param("s", $username);
    if($stmt->execute()){
        $result = $stmt->get_result();
        $tags = [];
        while ($tag = $result->fetch_array(MYSQLI_NUM)) $tags[] = $tag[0];
        $stmt->close();
        if($tags) return $tags;
    }
    return ["Nessuna Tag selezionata."];
}


function get_user_tags_id() {
    include('helper/connection.php');
    if(isset($_SESSION['logged_in'])){
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT Tags.id FROM UserTags join Tags on UserTags.tag=Tags.id where user=?");
        $stmt->bind_param("s", $username);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $tags = [];
            while ($tag = $result->fetch_array(MYSQLI_NUM)) $tags[] = $tag[0];
            $stmt->close();
            if($tags) return $tags;
        }
    }
    return ["Nessuna Tag selezionata."];
}

function get_game_tags($game_id) {
    include('helper/connection.php');
    $stmt = $conn->prepare("SELECT Tags.tag FROM GameTags join Tags on GameTags.tag=Tags.id where game_id=?");
    $stmt->bind_param("i", $game_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        $tags = [];
        while ($tag = $result->fetch_array(MYSQLI_NUM)) $tags[] = $tag[0];
        $stmt->close();
        return $tags;
    }
}

?>