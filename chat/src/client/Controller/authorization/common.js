export function authorizationCheck(err, token){
    if(err == ''){
        window.location.href = "../../index.html?token=" + token;
    }
    else{
        let errBox = document.querySelector('.error');
        errBox.innerHTML = err;
    }
}