<?php

require("config.inc.php");

if (!empty($_POST)) {
	$userID = $_POST['userID'];
	$eID = $_POST['eID'];
	$quantity = $_POST['quantity'];
	$hours = $_POST['hours'];
	$college = $_POST['college'];
	
	$in_stock = $_POST['in_stock'];

    $insert = "INSERT INTO avc_reservation(equipment,quantity,reserved_by,hours_reserved,college) "
            . "VALUES('$eID', '$quantity', '$userID', '$hours','$college');";

    try {
        $stmt = $db->prepare($insert);
        $result = $stmt->execute();
    } catch (PDOException $e) {
        $response['success'] = 0;
        $response['message'] = "Database Error!" . $e;
        die(json_encode($response));
    }
    if ($result) {
		$stock = $in_stock - $quantity;
		$update = "UPDATE avc_equipment SET in_stock = '$stock' WHERE id = $eID";
		$stmt1 = $db->prepare($update);
        $result1 = $stmt1->execute();
	
        $response['success'] = 1;
        $response['message'] = "Item Reserved. Wait for Dean's approval.";
    }
    
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "No Post!";
    die(json_encode($response));
}