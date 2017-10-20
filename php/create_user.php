<?php
     require 'connection.php';
     $domain_url = 'localhost/choose-the-color/';
     $q['1'] = 'I love you';
     $q['2'] = 'I wanna friend with you';
     $q['3'] = 'You are my brother|sister';
     $q['4'] = 'You are my Bestie';
     $q['5'] = 'I miss you';
     $q['6'] = 'I will kill you';
     $q['7'] = 'I need your mobile number';
     $q['8'] = 'Give me a chocolate';
     $q['9'] = 'Leave me alone';
     $qset['1'] = false ;  $qset['2'] = false ;  $qset['3'] = false ;
     $qset['4'] = false ;  $qset['5'] = false ;  $qset['6'] = false ;
     $qset['7'] = false ;  $qset['8'] = false ;  $qset['9'] = false ;
    if(!isset($_GET['username']) || strlen(filter_var($_GET['username'],FILTER_SANITIZE_STRING))<4 || strlen(filter_var($_GET['username'],FILTER_SANITIZE_STRING))>15 || !isNewUser(filter_var($_GET['username'],FILTER_SANITIZE_STRING),$conn)){
        sendRespone(false,'username is not valid or already exists!','');
        die();
    }
    if(isColorValid() && isAllSetRight($qset)){
        $username = filter_var($_GET['username'],FILTER_SANITIZE_STRING);
        $token_uuid = gen_uuid() ;
        $red = $q[$_GET['red']] ; $green = $q[$_GET['green']] ; $blue = $q[$_GET['blue']] ;
        $orange = $q[$_GET['orange']] ; $voilet = $q[$_GET['voilet']] ; $brown = $q[$_GET['brown']] ;
        $black = $q[$_GET['black']] ; $white = $q[$_GET['white']] ; $yellow = $q[$_GET['yellow']] ;
        $sql = "INSERT INTO user_profile (u_id,username,token,red,green,blue,orange,voilet,brown,black,white,yellow) VALUES (uuid(),'$username', '$token_uuid','$red','$green','$blue','$orange','$voilet','$brown','$black','$white','$yellow')";
        if ($conn->query($sql) === TRUE) {
            setcookie(
                "ctc_token",
                $token_uuid,
                time() + (10 * 365 * 24 * 60 * 60)
            );
            $link = $domain_url.'index.html?username='.$username ;
            sendRespone(true,'New User Successfully created!',$link);
        } else {
            sendRespone(false,'Some error Occured!','');
            die();
        }
        $conn->close();
    } else {
        sendRespone(false,'Wrong Number Ordering!','');
    }

function isNewUser($username_fn,$conn_fn){
    $sql = "SELECT * FROM user_profile where username='$username_fn'";
    $result = $conn_fn->query($sql);
    if ($result->num_rows > 0) {
       return false;
    } else {
      return true;
    }
}

function isColorValid(){
    if(isset($_GET['red']) && isset($_GET['green']) && isset($_GET['blue']) && isset($_GET['yellow']) && isset($_GET['brown']) && isset($_GET['voilet']) && isset($_GET['orange']) && isset($_GET['black'])&& isset($_GET['white'])){
        return true;
    } else {
        return false;
    }
}

function isAllSetRight($qset){
    if(!checkList('red') || $qset[$_GET['red']]){
        return false;
    } $qset[$_GET['red']] = true ;
    if(!checkList('green') || $qset[$_GET['green']]){
        return false;
    } $qset[$_GET['green']] = true ;
    if(!checkList('blue') || $qset[$_GET['blue']]){
        return false;
    } $qset[$_GET['blue']] = true ;
    if(!checkList('yellow') || $qset[$_GET['yellow']]){
        return false;
    } $qset[$_GET['yellow']] = true ;
    if(!checkList('voilet') || $qset[$_GET['voilet']]){
        return false;
    } $qset[$_GET['voilet']] = true ;
    if(!checkList('orange') || $qset[$_GET['orange']]){
        return false;
    } $qset[$_GET['orange']] = true ;
    if(!checkList('brown') || $qset[$_GET['brown']]){
        return false;
    } $qset[$_GET['brown']] = true ;
    if(!checkList('white') || $qset[$_GET['white']]){
        return false;
    } $qset[$_GET['white']] = true ;
    if(!checkList('black') || $qset[$_GET['black']]){
        return false;
    } $qset[$_GET['black']] = true ;
    return true;
}

function checkList($color){
    if($_GET[$color]=='1' || $_GET[$color]=='2' || $_GET[$color]=='3'  || $_GET[$color]=='4' || $_GET[$color]=='5' || $_GET[$color]=='6' || $_GET[$color]=='7' || $_GET[$color]=='8' || $_GET[$color]=='9'){
        return true;
    } else {
        return false;
    }
}

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

function sendRespone($_bool_,$_message_,$_link_){
    $_response['success'] = $_bool_ ;
    $_response['message'] = $_message_;
    $_response['link'] = $_link_ ;
    $_responseJson = json_encode($_response);
    echo $_responseJson;
}
?>