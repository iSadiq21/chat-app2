const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest(); //creating XML object 
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
               inputField.value = ""; // once message is inserted into db then leave input field blank
               scrollToBottom();
            }
        }
    }
    let formData = new FormData(form); // creating new formData object
    xhr.send(formData); // sending data to php
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}
chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}
setInterval(() => {
    let xhr = new XMLHttpRequest(); //creating XML object 
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active")){ //if active class not contains in chatbox the scroll to bottom
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form); // creating new formData object
    xhr.send(formData); // sending data to php
}, 500); // this function runs after 500ms

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}