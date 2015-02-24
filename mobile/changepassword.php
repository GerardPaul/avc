<?php
	require("conf.inc.php");
	
	if(!empty($_POST)){
		$old_pw = $_POST['oldpw'];
		$new_pw = $_POST['newpw'];
		$confirm_pw = $_POST['confirmpw'];
		$teacherID = $_POST['teacherID'];
		
		$encrypt_old = md5($old_pw);
		$encrypt_new = md5($new_pw);
		$check_pw = "SELECT * FROM teacher WHERE ID = '$teacherID' AND password = '$encrypt_old';";
		$check_stmt = $db->prepare($check_pw);
		$check_result = $check_stmt->execute();
		
		$rows = $check_stmt->fetch();
		if($rows){
			$update = "UPDATE teacher SET password = '$encrypt_new' WHERE ID = '$teacherID';";
			$update_stmt = $db->prepare($update);
			$update_result = $update_stmt->execute();
			$response['success'] = 1;
			$response['message'] = "Password Changed!";
			die(json_encode($response));
		}else{
			$response['success'] = 0;
			$response['message'] = "Old password is incorrect!";
			die(json_encode($response));
		}
	}else{
		$response['success'] = 0;
		$response['message'] = "No Post Received!";
		die(json_encode($response));
	}
?>