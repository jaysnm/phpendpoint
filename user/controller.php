<?php
function errorLogHandler($error, $type){
    $date_time = date('D d M Y | H:i:s');
    file_put_contents($type.".file", $date_time." | ".$error."\n", FILE_APPEND | LOCK_EX);
    return true;
}

function getMobleClinic($obj_id, $table, $connect){
    $query = "SELECT * FROM $table  WHERE clinic_id = :cid"; 
    try{
        $mclinic = $connect->prepare($query);
        $mclinic->execute(array(':cid'=>$obj_id));
        if($mclinic->rowCount() >= 1){
            $mclinic->setFetchMode(PDO::FETCH_ASSOC);
            $result = $mclinic->fetchAll(PDO::FETCH_ASSOC);
            $response = array_merge(array('status'=>200, 'respText'=>'Request Successful', 'respType'=>'success'), $result);
            echo json_encode($response);
        }else{
            echo json_encode(array('status'=>201, 'respText'=>'Moble Clinics returned Invalid', 'respType'=>'error'));
        }
    }
    catch(Excepton $error){
        errorLogHandler("Get Moble Clinics error  ".$error->getMessage(), 'request_query_error');
        echo json_encode(array('status'=>501, 'respText'=>'Request Faled Permanently', 'respType'=>'failed'));
    }
    

}
?>
