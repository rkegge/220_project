setupPage();

// console.log("in the JS validation");

function setupPage() {
    
}

if(document.querySelector(".input-container") != null){  
    document.getElementById("email").addEventListener("blur", checkEmail);

    document.getElementById('signup-form').addEventListener('submit', function(event){
        event.preventDefault();

        if(checkEmail() && checkPass()){
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;

            const request = new XMLHttpRequest();
            request.open("POST", "../api.php");
            request.setRequestHeader("Content-type", "application/json");

            //date = getDate();
            let requestData = {
                "type":"login",
                "email":email,
                "password":password,
                "return":["*"]
            };
            request.send(JSON.stringify(requestData));
            request.onload = function(){
                json = JSON.parse(this.responseText);
                if(json.status == "success"){
                    var url = '/project/home.php';
                    window.location.href = url;
                }
            }
        }
        else{
            checkEmail();
            checkPass();
            return false;
        }
    });
}

//---------------------------------- checking the email ----------------------------------
function checkEmail(){

    let emailVal = document.getElementById("email").value;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if(!emailPattern.test(emailVal)){
        document.getElementById("errEmail").innerHTML = "Please check your email";
        globalScope.email = false;
    }
    else{
        document.getElementById("errEmail").innerHTML = "";
        globalScope.email = true;
    }
}

//---------------------------------- checking the password ----------------------------------
function checkPass() {

    let passVal = document.getElementById("password").value;
    var passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    
    if(!passwordPattern.test(passVal)){
        document.getElementById("errPass").innerHTML = "Please check your password";
        if(document.getElementById("confirmPassword").value.trim().length != 0){
            checkConfirm();
        }
        globalScope.password = false;
    }
    else{
        document.getElementById("errPass").innerHTML = "";
        if(document.getElementById("confirmPassword").value.trim().length != 0){
            checkConfirm();
        }
        globalScope.password = true;
    }
}
