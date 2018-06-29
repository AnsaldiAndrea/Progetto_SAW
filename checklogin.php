<?php
    function show_error() {
        $_SESSION['error'] = ['danger', 'Invalid Credential. Try again'];
        header("Location: login.php");
        exit();
    }

    session_start();

    include('helper/connection.php');
    include('helper/functions.php');

    $username = htmlspecialchars(trim($_POST['username']));
    $username = $conn->real_escape_string($username);

    $password = sanitize($conn, $_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM User WHERE username=?");
    $stmt->bind_param("s", $username);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        if($result and password_verify($password, $result['password'])){
            $_SESSION['logged_in'] = True;
            $_SESSION['name'] = $result['name'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['address'] = $result['address'];
            $_SESSION['lat'] = $result['lat'];
            $_SESSION['lng'] = $result['lng'];
            $_SESSION['age'] = $result['age'];
            if($result['gender'] === 'm') $_SESSION['gender'] = "M";
            if($result['gender'] === 'f') $_SESSION['gender'] = "F";
            if($result['gender'] === 'a') $_SESSION['gender'] = "Altro";
            $_SESSION['error'] = ['success', "<strong>Login avvenuto con successo!</strong>"];
            header("Location: profilo.php");
            exit();
        }
    }
    $_SESSION = array();
    show_error();
    