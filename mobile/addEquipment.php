<?php

require("config.inc.php");

if (!empty($_POST)) {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];

    $insert = "INSERT INTO avc_equipment(item, quantity, in_stock) "
            . "VALUES('$item_name', '$quantity', '$quantity');";

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
        $response['message'] = "Equipment Added!";
    }
    
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "No Post!";
    die(json_encode($response));
}