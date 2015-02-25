<?php

require("config.inc.php");

if (!empty($_POST)) {
    $college_name = $_POST['college_name'];

    $insert = "INSERT INTO avc_college(college_name) "
            . "VALUES('$college_name');";

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
        $response['message'] = "College Added!";
    }
    
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "No Post!";
    die(json_encode($response));
}