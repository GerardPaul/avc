<?php
require("config.inc.php");

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM avc_users WHERE username = :username";

    $params = array(
        ':username' => $username
    );

    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($params);
    } catch (PDOException $e) {
        $response['success'] = 0;
        $response['message'] = "Cannot connect to network.";
        die(json_encode($response));
    }

    $row = $stmt->fetch();
    $login = false;
    $id = "";
    $type = "";
    if ($row) {
        $salt = $row['salt'];
        $userUsername = $row['username'];
        $userPassword = $row['password'];
        $hash = hash('sha256', $salt . $password);
        
        if ($userUsername == $username && $userPassword == $hash) {
            $login = true;
            $id = $row['id'];
            $type = $row['type'];
        }
    }else{
        $response['success'] = 0;
        $response['message'] = "User is not registered!";
        die(json_encode($response));
    }

    if ($login) {
        $response['success'] = 1;
        $response['message'] = "Login Successful!";
        $response['id'] = $id;
        $response['type'] = $type;

//        $lastLogin = "UPDATE teacher SET lastLogin = NOW() WHERE ID = :id ;";
//        $p = array(
//            ':id' => $id
//        );
//        $r = $db->prepare($lastLogin);
//        $q = $r->execute($p);

//        $getSubjects = "SELECT c.courseName, cc.section, cc.sy, t.fullName, cc.course
//				FROM teacher t, classcourse cc, course c
//				WHERE cc.teacher = :id AND cc.teacher = t.ID AND cc.course = c.ID";
//
//        $param = array(
//            ':id' => $id
//        );
//        try {
//            $stmnt = $db->prepare($getSubjects);
//            $subjectResult = $stmnt->execute($param);
//        } catch (PDOException $e) {
//            $response['message'] = "Database Error. Please try again.";
//        }
//        $rows = $stmnt->fetchAll();
//        if ($rows) {
//            $response['subjects'] = array();
//            foreach ($rows as $r) {
//                $subject = array();
//                $subject['courseName'] = $r['courseName'];
//                $subject['section'] = $r['section'];
//                $subject['sy'] = $r['sy'];
//                $subject['fullName'] = $r['fullName'];
//                $subject['courseID'] = $r['course'];
//                array_push($response['subjects'], $subject);
//            }
//        }

        die(json_encode($response));
    } else {
        $response['success'] = 0;
        $response['message'] = "Incorrect USERNAME or PASSWORD!";
        die(json_encode($response));
    }
} else {
    ?>
    <h1>Login</h1>
    <form action="login.php" method="post"> 
        Username:<br /> 
        <input type="text" name="username" placeholder="username" /> 
        <br /><br /> 
        Password:<br /> 
        <input type="password" name="password" placeholder="password" value="" /> 
        <br /><br /> 
        <input type="submit" value="Login" /> 
    </form>
    <?php
}
?>