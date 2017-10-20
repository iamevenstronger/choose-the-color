var url = window.location.href;
var username = getUsername(url);
var u_id = '';
var choosenColor = '';
// check for user cookie token
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var content = JSON.parse(this.responseText) ;
        console.log(content);
        if(content.success){
            window.location.href = "results.html?username=" + username;
        } else {
           checkUser(username) ;
        }
    }
};
xmlhttp.open("GET", "php/user_status.php?username="+username, true);
xmlhttp.send();

function checkUser(username){
    if (username.length == 0) { 
        document.write("Error send link!");
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = this.response;
                resp = JSON.parse(resp);
                u_id = resp.u_id ;
                console.log(resp);
                if(resp.success){
                    document.getElementById("username").innerHTML = username;
                } else {
                    document.write("Error send link!");
                }
            }
        };
        xmlhttp.open("GET", "php/check_user.php?username=" + username, true);
        xmlhttp.send();
    }
}

function sendClick(color){
    document.getElementById('colorSet').innerHTML = "you choosen "+color;
    choosenColor = color ;
}

function sendColor(){
    var attender = document.getElementById('attender').value ;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = JSON.parse(this.responseText);
            console.log(resp);
            if(resp.success){
                document.getElementById("result").innerHTML = attender+', '+resp.result;
            } else {
                document.getElementById("result").innerHTML = "<p style='color:#ff0000;'>"+resp.message+"</p>";
            }
        }
    };
    var payload = "php/send_color.php?u_id=" +u_id+"&attender="+attender+"&color="+choosenColor ;
    console.log(payload);
    xmlhttp.open("GET",payload, true);
    xmlhttp.send();
}

function reset(){
    document.getElementById("bdy").innerHTML = "<center><h4>You got the result!</h4><button onclick='redir()' class='btn btn-primary'>create account</button></center>";
}

function redir(){
    window.location.href='create_account.html';
}

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