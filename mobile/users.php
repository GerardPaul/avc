<?php

require("config.inc.php");

$type = $_POST['type'];
$college = $_POST['college'];

$query = "";
if($type == "admin"){
	$query = "SELECT u.id AS 'userID', u.firstname, u.lastname, u.username, u.type, c.college_name "
			. " FROM avc_users u LEFT JOIN avc_college c"
			. " ON u.college = c.id";
}else if($type == "dean"){
	$query = "SELECT u.id AS 'userID', u.firstname, u.lastname, u.username, u.type, c.college_name "
			. " FROM avc_users u, avc_college c"
			. " WHERE u.college = c.id AND u.college = $college";
}

$r = $db->prepare($query);
$q = $r->execute();

$rows = $r->fetchAll();

if ($rows) {
    $response['success'] = 1;
    $response['message'] = "All users.";
    $response['users'] = array();
    foreach ($rows as $r) {
        $users = array();
        $users['id'] = $r['userID'];
        $users['college_name'] = $r['college_name'];
        $users['full_name'] = $r['lastname'] . ", " . $r['firstname'];
        $users['username'] = $r['username'];
        $users['type'] = $r['type'];
        array_push($response['users'], $users);
    }
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "Not Available!";
    die(json_encode($response));
}