<?php

require("config.inc.php");


$query = "SELECT * FROM avc_equipment";

$r = $db->prepare($query);
$q = $r->execute();

$rows = $r->fetchAll();

if ($rows) {
    $response['success'] = 1;
    $response['message'] = "All equipments.";
    $response['items'] = array();
    foreach ($rows as $r) {
        $items = array();
        $items['id'] = $r['id'];
        $items['item'] = $r['item'];
        $items['quantity'] = $r['quantity'];
        $items['in_stock'] = $r['in_stock'];
        array_push($response['items'], $items);
    }
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "Not Available!";
    die(json_encode($response));
}