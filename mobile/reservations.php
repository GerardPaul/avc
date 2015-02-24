<?php

require("config.inc.php");


$query = "SELECT e.id AS 'equipmentID', e.item, e.quantity AS 'total', e.in_stock,"
        . " r.id AS 'reservationID', r.quantity AS 'number_reserved', r.hours_reserved, r.status,"
        . " date_format(r.date_reserved, '%W %m/%d/%Y %r %p') AS 'date_reserved', date_format(r.date_returned, '%W %m/%d/%Y %r %p') AS 'date_returned',"
        . " u.id AS 'userID', u.firstname, u.lastname, u.username,"
        . " c.id AS 'collegeID', c.college_name" 
        . " FROM avc_equipment e, avc_reservation r, avc_users u, avc_college c"
        . " WHERE r.equipment = e.id AND r.reserved_by = u.id AND r.college = c.id";

$r = $db->prepare($query);
$q = $r->execute();

$rows = $r->fetchAll();

if ($rows) {
    $response['success'] = 1;
    $response['message'] = "All reservations.";
    $response['reservations'] = array();
    foreach ($rows as $r) {
        $reservations = array();
        $reservations['eID'] = $r['equipmentID'];
        $reservations['rID'] = $r['reservationID'];
        $reservations['uID'] = $r['userID'];
        $reservations['cID'] = $r['collegeID'];
        $reservations['item'] = $r['item'];
        $reservations['total'] = $r['total'];
        $reservations['in_stock'] = $r['in_stock'];
        $reservations['number_reserved'] = $r['number_reserved'];
        $reservations['hours_reserved'] = $r['hours_reserved'];
        $reservations['status'] = $r['status'];
        $reservations['date_reserved'] = $r['date_reserved'];
        $reservations['date_returned'] = $r['date_returned'];
        $reservations['full_name'] = $r['lastname'] . ", " . $r['firstname'];
        $reservations['username'] = $r['username'];
        $reservations['college_name'] = $r['college_name'];
        array_push($response['reservations'], $reservations);
    }
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "Not Available!";
    die(json_encode($response));
}