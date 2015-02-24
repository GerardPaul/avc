<?php

require("conf.inc.php");
if (!empty($_POST)) {
    $save = $_POST['save'];
    $obj = json_decode($save);
    $attendance = $obj->{'attendance'};
    $size = sizeof($attendance);
    $response['success'] = 0;
    $response['message'] = "Initial Message!";
    die(json_encode($response));
    for ($i = 0; $i < $size; $i++) {
        $date = date('Y-m-d');
        $classID = $attendance[$i]->{'classID'};
        $status = $attendance[$i]->{'status'};
        $insert = "INSERT INTO attendance(date, class, status) VALUES('$date', '$classID', '$status');";
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
            $response['message'] = "Success!";
        }
    }
    die(json_encode($response));
} else {
    $response['success'] = 0;
    $response['message'] = "No Post!";
    die(json_encode($response));
}
?>
