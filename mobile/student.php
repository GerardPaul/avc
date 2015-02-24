<?php

require("conf.inc.php");

$query = "SELECT cc.ID AS \"classID\", s.studentName, s.parentName, s.parentPhone, s.ID AS \"studentID\",
				(SELECT getAttendance(:courseID, :section, :sy)) AS \"attendance\",
				(SELECT getPresent(:courseID, s.ID, :section, :sy)) AS \"present\",
				(SELECT getAbsent(:courseID, s.ID, :section, :sy)) AS \"absent\"
				FROM classCourse cc, student s, course c
				WHERE cc.course = :courseID 
					AND cc.section = :section
					AND cc.sy = :sy
					AND cc.student = s.ID
					AND cc.course = c.ID";
$params = array(
    ':courseID' => $_POST['courseID'],
    ':section' => $_POST['section'],
    ':sy' => $_POST['sy']
);
try {
    $stmt = $db->prepare($query);
    $result = $stmt->execute($params);
} catch (PDOException $e) {
    $response['success'] = 0;
    $response['message'] = "Database Error!";
    die(json_encode($response));
}
$rows = $stmt->fetchAll();
if ($rows) {
    $response['success'] = 1;
    $response['message'] = "Success!";
    $response['students'] = array();
    foreach ($rows as $row) {
        $student = array();
        $student['attendance'] = $row['attendance'];
        $student['present'] = $row['present'];
        $student['absent'] = $row['absent'];
        $student['classID'] = $row['classID'];
        $student['studentID'] = $row['studentID'];
        $student['studentName'] = $row['studentName'];
        $student['parentName'] = $row['parentName'];
        $student['parentPhone'] = $row['parentPhone'];
        array_push($response['students'], $student);
    }
    echo json_encode($response);
} else {
    $response['success'] = 0;
    $response['message'] = "Not Available!";
    die(json_encode($response));
}
?>