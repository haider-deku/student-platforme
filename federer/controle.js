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

window.onload = function() {
// Get the modal, open button, and close button
const modal = document.getElementById('popup');
const openModalBtn = document.getElementById('lunch_text_area');
const closeModalBtn = document.getElementById('closeModalBtn');

// When the user clicks on "What's on your mind?", open the modal
openModalBtn.addEventListener('click', function() {
    modal.style.display = 'flex';
});

// When the user clicks on the close button, close the modal
closeModalBtn.addEventListener('click', function() {
    modal.style.display = 'none';
});

// When the user clicks anywhere outside of the modal, close it
window.addEventListener('click', function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

};



document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.level-filter');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const selected = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const query = selected.length > 0
                ? '?levels=' + selected.join(',')
                : '';

            window.location.href = window.location.pathname + query;
        });
    });

    // Keep checkboxes checked on reload
    const urlParams = new URLSearchParams(window.location.search);
    const levelParams = urlParams.get('levels');
    if (levelParams) {
        const levels = levelParams.split(',');
        checkboxes.forEach(cb => {
            if (levels.includes(cb.value)) {
                cb.checked = true;
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("rech");
    const posts = document.querySelectorAll(".post");

    searchInput.addEventListener("input", function () {
        const keyword = this.value.toLowerCase();

        posts.forEach(post => {
            const content = post.querySelector(".post-content");
            if (content) {
                const text = content.textContent.toLowerCase();
                if (text.includes(keyword)) {
                    post.style.display = "block";
                } else {
                    post.style.display = "none";
                }
            }
        });
    });
});
