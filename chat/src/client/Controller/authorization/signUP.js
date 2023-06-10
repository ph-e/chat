import { socket } from '../socket/socket.js';

document.getElementById("signup-btn").addEventListener("click", signUP);

function signUP(){
    let form = document.querySelector('.appForm');
    let errBox = document.querySelector('.error');
    let name = form.elements['name'].value;
    let password = form.elements['password'].value;
    let r_password = form.elements['r_password'].value;
    let errors = '';
    if (/[ '`]/.test(name)) {
        errors = 'name contains illegal characters';
    }
    if (/[ '`]/.test(password)) {
        errors = 'password contains illegal characters';
    }
    if (password != r_password) {
        errors = 'password mismatch';
    }
    if (name.length < 3 || password.length < 3) {
        errors = 'username and password must be more than 3 characters';
    }
    if (errors != '') {
        errBox.innerHTML = errors;
    } else {
        addUser(name,password);
    }
}

function addUser(username,password){
    let response = {
        functionName: 'signUP',
        name: username,
        password: password
    };
    socket.send(JSON.stringify(response));
}