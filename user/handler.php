<?php 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
require_once('config.php');
   if(isset($_POST)){
	$request = $_POST['request'];
	if($request == "services"){
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$gender = $_POST['gender'];
		$lat = round((float)$_POST['lat'], 8);
		$lng = round((float)$_POST['lng'], 8);
		$connect = $GLOBALS['connect'];
		$table = "reports";
		$storage_file = file_get_contents("user-details.log", true);
		$user_data = json_decode($storage_file, true);
		unset($storage_file);
		$user_data[] =array('username'=>$name, 'phone'=>$phone, 'gender'=>$gender, 'lat'=>$lat, 'lng'=>$lng);
		file_put_contents("user-details.log", json_encode($user_data), true);
		$query = "INSERT INTO $table (`uname`, `phone`, `lat`, `lng`, `gender`) VALUES (:uname, :phone, :lat, :lng, :gender)";
		try{
			$usrRequest = $connect->prepare($query);
		 	$usrRequest->execute(array(':uname'=>$name, ':phone'=>$phone, ':lat'=>$lat, ':lng'=>$lng, ':gender'=>$gender));
			getMobleClinic(1, 'mobileclinics', $connect);
		}
		catch(Exception $error){
			errorLogHandler("Request Log into database Failure   ".$error->getMessage(), 'error_logs');
			echo "Request Failed Permanently"; 
		}
	
	}else if($request == "listview"){

	}
	else if($request == "objectview"){

	}else{
		echo json_encode("No such request Supported!");
	}
  
}
else{
echo json_encode("Failed");
}

?>
