function createAccount(){
    var username = document.getElementById('username').value;
    var red = document.getElementById('red').value ;
    var green = document.getElementById('green').value ;
    var blue = document.getElementById('blue').value ;
    var yellow = document.getElementById('yellow').value ;
    var voilet = document.getElementById('voilet').value ;
    var orange = document.getElementById('orange').value ;
    var brown = document.getElementById('brown').value ;
    var white = document.getElementById('white').value ;
    var black = document.getElementById('black').value ;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(this.responseText);
                console.log(resp);
                if(resp.success){
                    document.getElementById('status').innerHTML = "<span style='color:green;'>"+resp.message+"</span>";
                    document.getElementById('resLink').value = resp.link ;
                } else {
                    document.getElementById('status').innerHTML = "<span style='color:red;'>"+resp.message+"</span>";
                }
            }
        };
        var payload = "php/create_user.php?username="+username+"&red="+red+"&green="+green+"&blue="+blue+"&yellow="+yellow+"&voilet="+voilet+"&orange="+orange+"&brown="+brown+"&white="+white+"&black="+black ;
        xmlhttp.open("GET",payload, true);
        xmlhttp.send();
}

function copyText(){
    var copyText = document.getElementById("resLink");
    copyText.select();
    document.execCommand("Copy");
    document.getElementById('copyStatus').innerHTML = 'Copied';
}