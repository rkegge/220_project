var toApi, fromApi;
var talkingTo;

function loadChat(name, email, photoUrl, toApis, fromApis) {

    var messageInput = document.getElementById("messageInput");
    messageInput.placeholder = "Enter your message...";

    // window.location.reload();

    toApi = toApis;
    fromApi = fromApis;

    talkingTo = email;

    // console.log("Setting cookie: " + email);
    document.cookie = "talkingTo=" + email;


    // console.log("url: " + photoUrl);
    document.querySelector('.chat-about h6').textContent = name;

    // Update profile photo
    const profilePhoto = document.querySelector('.chatOpenWith');
    profilePhoto.src = photoUrl;

    document.getElementById('chat-history-container').style.display = 'block';

    // Clear the chat history
    // const chatHistory = document.querySelector('.chat-history');
    // chatHistory.innerHTML = '';

    // Fetch and display messages
    fetchMessages(fromApi);
}

function fetchMessages(api) {
    const chatHistory = document.querySelector('.chat-history');
    chatHistory.innerHTML = '';

    fetch('http://imy.up.ac.za/u20426586/getMessages.php?api=' + api)
        .then(response => response.json())
        .then(messages => {
            // Handle the retrieved messages
            if (messages.length > 0) {
                messages.forEach(message => {
                    if (message.toApi === toApi || message.fromApi === toApi) {
                        // console.log('Message:', message);
                        const messageElement = document.createElement('li');
                        messageElement.className = 'clearfix';
                        messageElement.style.listStyleType = 'none'; 

                        const messageData = document.createElement('div');
                        messageData.className = 'message-data';
                        const messageTime = document.createElement('span');
                        messageTime.className = 'message-data-time';
                        messageTime.textContent = message.time;
                        messageData.appendChild(messageTime);
                        messageElement.appendChild(messageData);

                        if (message.toApi === fromApi) {
                            const myMessage = document.createElement('div');
                            myMessage.className = 'message my-message';
                            myMessage.textContent = message.message;
                            messageElement.appendChild(myMessage);
                        } else {
                            const otherMessage = document.createElement('div');
                            otherMessage.className = 'message other-message float-right';
                            otherMessage.textContent = message.message;
                            messageElement.appendChild(otherMessage);
                        }

                        chatHistory.appendChild(messageElement);
                    }
                    
                });
            } else {
                console.log('No messages available.');
                // Handle the case when no messages are available
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
}

function sendy(to, from, message, time) {

    // console.log("IN SEND," + message);

    var msg = document.getElementById('messageInput');
    msg.value = "";

    // console.log("sending message to db");

    var xhr = new XMLHttpRequest();
    var url = 'http://imy.up.ac.za/u20426586/config.php';

    var data = {
        sender: from,
        receiver: to,
        message: message,
        time: time
    };

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onload = function () {
        if (xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };

    xhr.send(JSON.stringify(data));

}

function messages(){

    const now = new Date();

    // Get hours and minutes
    const hours = now.getHours().toString().padStart(2, '0'); // Ensure two digits
    const minutes = now.getMinutes().toString().padStart(2, '0'); // Ensure two digits

    const currentTime = hours + ':' + minutes;

    // var message = document.getElementById('messageInput').value;
    // message.value = "";

    var message = document.getElementById('messageInput').value;

    sendy(toApi, fromApi, message, currentTime);
}