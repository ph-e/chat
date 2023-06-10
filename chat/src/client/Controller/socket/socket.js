import { handleSocketMessage } from "./message.js";

export const socket = new WebSocket("ws://localhost:2356");

socket.onopen = function() {
    console.log('connection');
};


socket.addEventListener('message', handleSocketMessage);

socket.onclose = function (){
    console.log('close connection');
}

socket.onerror = function (){
    console.log('error');
}