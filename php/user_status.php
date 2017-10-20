<?php
    require 'connection.php';
   if(isset($_COOKIE['ctc_token']) && isset($_GET['username'])){
          $token = filter_var($_COOKIE['ctc_token'],FILTER_SANITIZE_STRING);
          if(isOtherUser(filter_var($_GET['username'],FILTER_SANITIZE_STRING),$token,$conn)){
            sendResponse(false,"It not your account!");
            die();
          }
          $sql = "SELECT * FROM user_results where u_id IN (SELECT u_id FROM user_profile where token='$token')";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              $res = '';
            while($row = $result->fetch_assoc()) {
                $res = "<tr><td>".$row['attender']."</td><td>".$row['colour']."</td><td>".$row['result']."</td></tr>".$res;
            }
            sendResponse(true,$res);
          } else {
            $msg = "<tr><td colspan='3'>No One Clicked Colour</td></tr>" ;
            sendResponse(true,$msg);
          }
   } else {
        sendResponse(false,"cookie expired!");
   }

function isOtherUser($_username,$_token,$_conn){
    $sql = "SELECT username FROM user_profile where token='$_token'";
    $result = $_conn->query($sql);
    if ($result->num_rows > 0) {
        $value = mysqli_fetch_object($result);
        if($value->username == $_username){
            return false;
        }  else {
            return true;
        }
    } else {
        return true;
    }
}
function sendResponse($_bool,$_message){
    $_respone['success'] = $_bool ;
    $_respone['message'] = $_message;
    $_responseJson = json_encode($_respone);
    echo $_responseJson;
}
?>