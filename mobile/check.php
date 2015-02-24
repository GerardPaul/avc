<?php
	require("conf.inc.php");
	
	if(!empty($_POST)){
		$save = json_decode($_POST['save']);
		$attendance = $save->{'attendance'};
		$size = sizeof($attendance);
		
		for($i = 0; $i < $size; $i++){
			$date = date('Y-m-d');
			$classID = $attendance[$i]->{'classID'};
			$status = $attendance[$i]->{'status'};
			$insert = "INSERT INTO attendance(date, class, status)
						VALUES(DATE_FORMAT(NOW(),'%Y-%m-%d'),'$classID','$status');";
			$stmt = $db->prepare($insert);
			$result = $stmt->execute();
		}
		$response['success'] = 1;
		$response['message'] = "Success!";
		die(json_encode($response));
	}else{
		$response['success'] = 0;
		$response['message'] = "No Post Received!";
		die(json_encode($response));
	}
?>