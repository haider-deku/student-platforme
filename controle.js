function verif() {
    ad=document.getElementById("ad").value;
    pwd=document.getElementById("pwd").value;
    errorSpan = document.getElementById("error1");
    errorSpan2 = document.getElementById("error2");
    isValid = true;
    if (ad=="" || ad.length<21) {
        document.getElementById("ad").value="";
        errorSpan.innerHTML = "adresse non valide";
        errorSpan.style.color="red";
        isValid = false
    } else if (!ad.endsWith("@isitcom.rnu.tn")) {
        errorSpan.innerHTML = "Il faut entrer une adresse ISITCOM valide";
        document.getElementById("ad").value="";
        errorSpan.style.color="red";
        isValid =false;
    }
    if (pwd.length < 8) {
        document.getElementById("pwd").value = "";
        errorSpan2.innerHTML = "Mot de passe non valide";
        errorSpan2.style.color = "red";
        isValid = false;
    }
    return isValid
}
function verif2() {
    email = document.getElementById("ad").value;
    nom = document.getElementById("nom").value;
    password = document.getElementById("pwd").value;
    confirmPassword = document.getElementById("cpwd").value;
    level = document.getElementById("l").value;
    console.log(level);
    errorEmail = document.getElementById("errmail");
    errorPassword = document.getElementById("errpwd");
    errorConfirmPassword = document.getElementById("errcpwd");
    errorLevel = document.getElementById("errl");

    isValid = true;
    
    // Email validation
    if (email === "" || email.length < 21) {
        errorEmail.innerHTML = "Adresse non valide";
        errorEmail.style.color = "red";
        isValid = false;
    } else if (!email.endsWith("@isitcom.rnu.tn")) {
        errorEmail.innerHTML = "Il faut entrer une adresse ISITCOM valide";
        errorEmail.style.color = "red";
        isValid = false;
    } else {
        errorEmail.innerHTML = "";
    }

    // Password validation
    if (password.length < 8) {
        errorPassword.innerHTML = "Mot de passe non valide (min 8 caractères)";
        errorPassword.style.color = "red";
        isValid = false;
    } else {
        errorPassword.innerHTML = "";
    }

    // Confirm password validation
    if (confirmPassword !== password) {
        errorConfirmPassword.innerHTML = "Les mots de passe ne correspondent pas";
        errorConfirmPassword.style.color = "red";
        isValid = false;
    } else {
        errorConfirmPassword.innerHTML = "";
    }

    // Level selection validation
    if (level == "nothing") {
        errorLevel.innerHTML = "Veuillez sélectionner un niveau";
        errorLevel.style.color = "red";
        isValid = false;
    } else {
        errorLevel.innerHTML = "";
    }

    return isValid;
}
