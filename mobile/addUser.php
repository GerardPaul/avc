<?php

require("config.inc.php");

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $type = $_POST['type'];
    $college = $_POST['college'];

    $salt1 = md5(uniqid(rand(), true));
    $salt = substr($salt1, 0, 25);
    $hashPassword = hash('sha256', $salt . $password);

    $insert = "INSERT INTO avc_users(username, password, firstname, lastname, college, type, salt) "
            . "VALUES('$username', '$hashPassword', '$firstname', '$lastname', '$college', '$type', '$salt');";

    try {
        $stmt = $db->prepare($insert);
        $result = $stmt->execute();
    } catch (PDOException $e) {
        $response['success'] = 0;
        $response['message'] = "Database Error!";
        die(json_encode($response));
    }
    if ($result) {
        $response['success'] = 1;
        $response['message'] = "User Added!";
    }
    
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "No Post!";
    die(json_encode($response));
}