import { socket } from './socket/socket.js';


document.getElementById("message-btn").addEventListener("click", sendMessage);

socket.onopen = function (){
    let url = new URL(window.location.href);
    let params = new URLSearchParams(url.search);
    let paramValues = params.getAll('token');
    let paramValue;
    if (paramValues.length === 1) {
        paramValue = paramValues[0];
        let response = {
            functionName: 'connect',
            token: paramValue
        };
        socket.send(JSON.stringify(response));
    } else {
        window.location.href = '../signIN.html';
    }
};

function sendMessage(){
    let inputElement = document.getElementById("message");
    let text = inputElement.value;
    if (text != ''){
        let response = {
            functionName: 'sendMessage',
            message: text
        };

        socket.send(JSON.stringify(response));
    }
    inputElement.value = '';
}
