<?php
    require 'connection.php';
    if(isset($_GET['u_id']) && isset($_GET['color']) && isset($_GET['attender']) && isColorValid($_GET['color'])){
        $color = filter_var($_GET['color'],FILTER_SANITIZE_STRING); 
        $u_id = filter_var($_GET['u_id'],FILTER_SANITIZE_STRING); 
        $attender = filter_var($_GET['attender'],FILTER_SANITIZE_STRING); 
        if(strlen($attender) >15){
            sendResponse(false,"Name should below 15 char(s)");
            die();
        }
        $sql = "SELECT $color FROM user_profile where u_id='$u_id' limit 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
           $value = mysqli_fetch_object($result);
           $res = $value->$color ;
           $sql2 = "INSERT INTO user_results(id,u_id,attender,result,colour) values(0,'$u_id','$attender','$res','$color')";
           if ($conn->query($sql2) === TRUE){
            $response['success'] = true ;
            $response['result'] = $res ;
            $response['message'] = 'you got the result!';
            $responseJson = json_encode($response);
            echo $responseJson;
           } else {
            sendResponse(false,'Result not saved!');
           }
        } else {
          sendResponse(false,'No result found!');
        }
        $conn->close();
    } else {
        sendResponse(false,'Enter Valid Input!');
    }
function isColorValid($color){
    return ($_GET['color']=='red' || $_GET['color']=='green' || $_GET['color']=='blue' || $_GET['color']=='yellow' || $_GET['color']=='orange' || $_GET['color']=='voilet' || $_GET['color']=='white' || $_GET['color']=='black');
}
function sendResponse($_bool,$_message){
    $_response['success'] = $_bool ;
    $_response['message'] = $_message;
    $_responseJson = json_encode($_response);
    echo $_responseJson;
}

?>