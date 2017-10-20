// get results
var url = window.location.href;
var username = getUsername(url);
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var content = JSON.parse(this.responseText) ;
        console.log(content);
        if(content.success){
            document.getElementById('tbBody').innerHTML = content.message ;
        } else {
           document.write("No Authentication provided!");
        }
    }
};
xmlhttp.open("GET", "php/user_status.php?username="+username, true);
xmlhttp.send();

function getUsername(_username){
    var str = '';
    var ind = 0 ;
    for(var i=0;i<_username.length;i++){
       if(_username[i] == '='){
           ind = (i+1) ;
           break;
       }
    }
    for(var i=ind;i<_username.length;i++){
     if(_username[i] == '&'){
         ind = (i+1);
         break;
     }
     str += _username[i] ;
   }
    console.log(str);
    return str;
 }