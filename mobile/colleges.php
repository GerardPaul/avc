<?php

require("config.inc.php");


$query = "SELECT * FROM avc_college";

$r = $db->prepare($query);
$q = $r->execute();

$rows = $r->fetchAll();

if ($rows) {
    $response['success'] = 1;
    $response['message'] = "All colleges.";
    $response['colleges'] = array();
    foreach ($rows as $r) {
        $colleges = array();
        $colleges['id'] = $r['id'];
        $colleges['name'] = $r['college_name'];
        array_push($response['colleges'], $colleges);
    }
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "Not Available!";
    die(json_encode($response));
}