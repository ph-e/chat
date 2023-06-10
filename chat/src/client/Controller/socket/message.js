import { updateUserList, getSession, showMessages, addMessage } from "../utils.js";
import { authorizationCheck } from '../authorization/common.js';


export function handleSocketMessage(response){
    let data = JSON.parse(response.data);
    if(data.functionName == 'getSession'){
        getSession(data);
    }
    else if(data.functionName == 'updateUserList'){
        updateUserList(data.name);
    }
    else if (data.functionName == 'authorizationCheck'){
        authorizationCheck(data.err,data.token);
    }
    else if (data.functionName == 'getMessages'){
        showMessages(data.messages);
    }
    else if (data.functionName == 'updateMessage'){
        addMessage(data.messages);
    }
};