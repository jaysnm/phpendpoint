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
		$lat = round(float($_POST['lat']), 8);
		$lng = round(float($_POST['lng']), 8);
		$connect = $GLOBALS['connect'];
	   $storage_file = file_get_contents("user-details.log", true);
	   $user_data = json_decode($storage_file, true);
	   unset($storage_file);
	   $user_data[] =array('username'=>$name, 'phone'=>$phone, 'gender'=>$gender, 'lat'=>$lat, 'lng'=>$lng);
	   file_put_contents("user-details.log", json_encode($user_data), true);
	   $query = "INSERT INTO `reports` (`object_id`, `name`, `phone`, `lat`, `lng`, `gender`) VALUES 		(NULL, :name, :phone, ;lat, :lng, :gender)";
		try{
        $usrRequest = $connect->prepare($query);
        $usrRequest->execute(array(':name'=>$name, ':phone'=>$phone, ':lat'=>$lat, ':lng'=>$lng, ':gender'=>$gender));
        echo json_encode(array(status=>200, respText=>"Request Successful"));
      }
      catch(Excption $error){
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
