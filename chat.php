<?php
session_start();
include_once "connection.php";

// Ensure the user is logged in as either a customer or employer
if (!isset($_SESSION['cus_id']) && !isset($_SESSION['emp_id'])) {
    echo "<script>alert('You must log in to use the chat.')</script>";
    echo '<meta http-equiv="refresh" content="0;URL=login.php"/>';
    exit();
}

// Set user ID and role
$cus_id = $_SESSION['cus_id'] ?? null;
$emp_id = $_SESSION['emp_id'] ?? null;
$user_role = isset($_SESSION['cus_id']) ? 'customer' : 'employer';
?>
<div id="chatBubble" class="chat-bubble" onclick="toggleChatForm()">
    💬
</div>

<div id="chatForm" class="chat-form" style="display: none;">
    <h3>Chat với chúng tôi</h3>

    <div class="chat-messages" id="chatMessages">
        <!-- Tin nhắn sẽ hiển thị tại đây -->
    </div>

    <form id="chatFormInner" method="POST" action="sendMessage.php" class="chat-input-container">
        <div class="form-group message-input-group">
            <textarea class="form-control" id="message" name="message" rows="1" placeholder="Nhập tin nhắn..." required></textarea>
            <button type="submit" class="btn btn-primary send-button">Gửi</button>
        </div>
    </form>
</div>

<script>
function toggleChatForm() {
    const chatForm = document.getElementById("chatForm");
    chatForm.style.display = chatForm.style.display === "none" ? "block" : "none";
}

document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chatFormInner');
    const chatMessages = document.getElementById('chatMessages');
    const receiverId = /* Set receiver ID based on session data from PHP */

    chatForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const messageInput = document.getElementById('message');
        const message = messageInput.value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "sendMessage.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    const newMessage = document.createElement('p');
                    newMessage.classList.add('sent');
                    newMessage.textContent = message;
                    chatMessages.appendChild(newMessage);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    messageInput.value = ''; // Clear the input
                } else {
                    alert(response.message);
                }
            } else {
                alert('Failed to send message. Please try again.');
            }
        };

        xhr.send(`message=${encodeURIComponent(message)}&receiver_id=${encodeURIComponent(receiverId)}`);
    });

    // Poll for new messages
    setInterval(fetchMessages, 3000);

    function fetchMessages() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "getMessage.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    chatMessages.innerHTML = ''; // Clear messages
                    response.messages.forEach(msg => {
                        const msgElement = document.createElement('p');
                        msgElement.textContent = msg.content;
                        msgElement.classList.add(msg.sender === 'customer' ? 'sent' : 'received');
                        chatMessages.appendChild(msgElement);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        };
        xhr.send();
    }
});

</script>





<style>
/* Bubble chat icon */
.chat-bubble {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background-color: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

/* Chat form container */
.chat-form {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 300px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    padding: 15px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Chat messages container */
.chat-messages {
    height: 250px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

.chat-messages p {
    padding: 10px;
    background: #007bff;
    color: white;
    border-radius: 10px;
    margin-bottom: 10px;
    max-width: 80%;
    word-wrap: break-word;
    align-self: flex-start;
}

.chat-messages p.sent {
    background: #28a745;
    align-self: flex-end;
}

/* Chat input container */
.chat-input-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Input and send button alignment */
.message-input-group {
    display: flex;
    width: 100%;
}

.form-control {
    flex: 1;
    resize: none;
    padding: 8px;
    border-radius: 20px;
    border: 1px solid #ddd;
    margin-right: 10px;
    font-size: 14px;
}

/* Send button style */
.send-button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.send-button:hover {
    background-color: #0056b3;
}

.send-button:active {
    background-color: #004b9b;
}
</style>


