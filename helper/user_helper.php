<?php

function get_user_info($username){
    include('helper/connection.php');
    include_once('helper/functions.php');

    $username = sanitize($conn, $username);

    $stmt = $conn->prepare("SELECT * FROM User WHERE username=?");
    $stmt->bind_param("s", $username);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    }
    $stmt->close();
    return $result;
}

    
?>