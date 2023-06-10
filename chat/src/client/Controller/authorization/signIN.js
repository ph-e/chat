import { socket } from '../socket/socket.js';

document.getElementById("signin-btn").addEventListener("click", signIN);

function signIN(){
    let form = document.querySelector('.appForm');
    let username = form.elements['name'].value;
    let password = form.elements['password'].value;
    let response = {
        functionName: 'signIN',
        name: username,
        password: password
    };
    socket.send(JSON.stringify(response));
}
