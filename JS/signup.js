let globalScope = this;

if(document.querySelector(".sign-up-form") != null){
    
    let email = false;
    let name = false;
    let surname = false;
    let password = false;
    let confirmPass = false;
    
    //getting all the inputs
    document.getElementById("name").addEventListener("blur", checkName);
    document.getElementById("surname").addEventListener("blur", checkSurname);
    document.getElementById("email").addEventListener("blur", checkEmail);
    document.getElementById("password").addEventListener("blur", checkPass);
    document.getElementById("confirmPassword").addEventListener("blur", checkConf);

    document.getElementById('registerFrom').addEventListener('submit', function(event){
        //if evrything is valid
        if(globalScope.name && globalScope.surname && globalScope.email && globalScope.password && globalScope.confirmPass){
            return true;
        }
        else{
            event.preventDefault();
            checkName();
            checkSurname();
            checkEmail();
            //passwords
            checkConf();
            checkPass();
            
            
            return false;
        }
    });
}

//---------------------------------- checking the name ----------------------------------
function checkName() {

    let nameVal = document.getElementById("name").value;
    var namePattern = /^[a-zA-Z]{3,}$/;

    if(!namePattern.test(nameVal)){
        document.getElementById("errName").innerHTML = "Please check your name";
        globalScope.name = false;
    }
    else{
        document.getElementById("errName").innerHTML = "";
        globalScope.name = true;
    }
}

//---------------------------------- checking the surname ----------------------------------
function checkSurname() {

    let surnameVal = document.getElementById("surname").value;
    var surnamePattern = /^[a-zA-Z]{3,}$/;

    if(!surnamePattern.test(surnameVal)){
        document.getElementById("errSurName").innerHTML = "Please check your surname";
        globalScope.surname = false;
    }
    else{
        document.getElementById("errSurName").innerHTML = "";
        globalScope.surname = true;
    }
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

//---------------------------------- make sure passwords match ----------------------------------
function checkConf(){

    let passValConf = document.getElementById("confirmPassword").value;
    var passVal = document.getElementById("password").value;

    if(passVal != passValConf){
        document.getElementById("errPassConf").innerHTML = "Please check your passwords match";
        globalScope.confirmPass = false;
    }
    else{
        document.getElementById("errPassConf").innerHTML = "";
        globalScope.confirmPass = true;
    }
}

