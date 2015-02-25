<?php

require("config.inc.php");

if (!empty($_POST)) {
	$id = $_POST['id'];

	$query = "SELECT u.id AS 'userID', u.username, u.password, u.salt, u.firstname, u.lastname, u.type,"
			. " c.college_name FROM avc_users u LEFT JOIN avc_college c ON u.college = c.id AND u.id = '$id'";

	$r = $db->prepare($query);
	$q = $r->execute();

	$rows = $r->fetchAll();

	if ($rows) {
		$response['success'] = 1;
		$response['message'] = "User profile.";
		$response['profile'] = array();
		foreach ($rows as $r) {
			$profile = array();
			$profile['id'] = $r['userID'];
			$profile['username'] = $r['username'];
			$profile['password'] = $r['password'];
			$profile['salt'] = $r['salt'];
			$profile['firstname'] = $r['firstname'];
			$profile['lastname'] = $r['lastname'];
			$profile['type'] = $r['type'];
			$profile['college_name'] = $r['college_name'];
			array_push($response['profile'], $profile);
		}
		die(json_encode($response));
	} else {
		$response['success'] = 0;
		$response['message'] = "Not Available!";
		die(json_encode($response));
	}
} else {
    $response['success'] = 0;
    $response['message'] = "No Post!";
    die(json_encode($response));
}