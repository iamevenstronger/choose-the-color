<?php
  require 'connection.php';
// usercheck redirection
  if(isset($_GET['username'])){
  $username = filter_var($_GET['username'],FILTER_SANITIZE_STRING);
    $sql = "SELECT u_id FROM user_profile where username='$username' limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
       $value = mysqli_fetch_object($result);
        $respone['success'] = true ;
        $respone['u_id'] = $value->u_id ;
        $respone['message'] = 'username is valid';
        $responseJson = json_encode($respone);
        echo $responseJson;
    } else {
      $respone['success'] = false ;
      $respone['message'] = 'username is invalid';
      $responseJson = json_encode($respone);
      echo $responseJson;
    }
    $conn->close();
  } else {
      echo "Bad Request!";
  }
?>