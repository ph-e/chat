import { socket } from "./socket/socket.js";


const chatField = document.getElementById('chatField');

export function updateUserList(users) {
    let userListElement = document.querySelector('.name');
    userListElement.innerHTML = '';
    for (let [key, name] of Object.entries(users)) {
        userListElement.innerHTML += '<br>' + name;
    }
}

export function getSession(data){
    if("name" in data){
        let response = {
            functionName: 'addUser'
        };

        socket.send(JSON.stringify(response));
    }
    else{
        window.location.href = '../signIN.html';
    }
}

export function showMessages(messages){
    messages.forEach(message => {
        addMessage(message);
    });
}

export function addMessage(message){
    const { id, name, text } = message;
    const messageElement = document.createElement('div');
    messageElement.classList.add('messages');
    messageElement.innerText = `${name}: ${text}`;
    chatField.appendChild(messageElement);
}