<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../static/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
      /* Basic Reset */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body, html {
        height: 100%;
        width: 100%;
        font-family: 'Arial', sans-serif;
        background-color: #f0f8ff;
      }

      /* Container to hold both sections */
      .container {
        display: flex;
        height: 100vh;
        width: 100%;
        padding: 20px; /* Uniform gap around the container */
        gap: 20px; /* Consistent gap between left and right sections */
      }

      /* Left Section (Instruction Section) */
      .instructions {
        width: 50%; /* Set to 50% for more balanced spacing */
        background-color: #ffffff;
        border: 2px solid #ccc;
        border-radius: 8px; /* Rounded corners */
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
        overflow-y: auto;
      }

      .instructions h1, .instructions h2 {
        color: #333;
        text-align: center;
        margin-bottom: 15px;
      }

      .instructions h3 {
        color: #333;
        margin-bottom: 10px;
        font-weight: normal;
      }

      .instructions ul {
        list-style-type: none;
      }

      .instructions li {
        margin-bottom: 15px;
        font-size: 16px;
        line-height: 1.6;
      }

      /* Right Section (Conversation Section) */
      .conversation {
        width: 50%; /* Set to 50% for more balanced spacing */
        background-color:rgb(248, 244, 244);
        border: 2px solid #ccc;
        border-radius: 8px; /* Rounded corners */
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
        display: flex;
        flex-direction: column;
      }

      .msger-header {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
      }

      .msger-chat {
        flex: 1;
        overflow-y: auto;
        margin-bottom: 20px;
        padding-right: 10px;
      }

      .msger-inputarea {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
      }

      .msger-input {
        width: 85%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .msger-send-btn {
        width: 10%;
        padding: 12px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
      }

      .msger-send-btn:hover {
        background-color: #45a049;
      }

      /* Styling for the message bubbles */
      .msg {
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
      }

      .msg .msg-bubble {
        background-color: #f1f1f1;
        padding: 12px;
        border-radius: 10px;
        max-width: 60%;
        word-wrap: break-word;
      }

      .msg.left-msg .msg-bubble {
        background-color: #e0e0e0;
      }

      .msg-info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: gray;
        margin-bottom: 5px;
      }

      .msg-info-name {
        font-weight: bold;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <!-- Left Section: Instructions -->
      <div class="instructions" style="font-family: 'Arial', sans-serif; font-weight: normal;">

<br><br><h1 style="font-weight: bold; font-size: 32px; color: #333;">Hi, welcome to the chatbot!</h1><br><br>
<h2 style="font-weight: bold; font-size: 24px; color: #555;">Mental Health Report</h2><br><br>

<ul style="list-style-type: disc; padding-left: 20px; font-size: 18px; color: #444;">
  <li style="margin-bottom: 10px; line-height: 1.5;"><h3>If your score is greater than <span style="color:green; font-weight: bold;">71%</span>, you are <span style="color:green; font-weight: bold;">"MENTALLY HEALTHY".</span>
    </h3></li><br><br>
  <li style="margin-bottom: 10px; line-height: 1.5;"><h3>If your score is between <span style="color:purple; font-weight: bold;">51% to 70%</span>, you need to take care of your mental health.
    </h3></li><br><br>
  <li style="margin-bottom: 10px; line-height: 1.5;"><h3>If your score is between <span style="color:blue; font-weight: bold;">41% to 50%</span>, you need to Contacts a doctor.
    </h3></li><br><br>
  <li style="margin-bottom: 10px; line-height: 1.5;"><h3>If the score is less than <span style="color:red; font-weight: bold;">40%</span>, you should approach a rehabilitation center.
    </h3></li>
</ul>

</div>

      <!-- Right Section: Chatbot Conversation -->
      <div class="conversation">
        <header class="msger-header">
          Chat bot
        </header>

        <main class="msger-chat">
          <div class="msg left-msg">
            <div class="msg-bubble">
              <div class="msg-info">
                <div class="msg-info-name">Chatbot</div>
                <div class="msg-info-time"></div>
              </div>
              <div class="msg-text">
              </div>
            </div>
          </div>
        </main>

        <form class="msger-inputarea">
          <input type="text" class="msger-input" id="textInput" placeholder="Enter your message..."autocomplete="off">
          <button type="submit" class="msger-send-btn">Send</button>
        </form>
      </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>
    <script>
      const msgerForm = document.querySelector(".msger-inputarea");
      const msgerInput = document.querySelector(".msger-input");
      const msgerChat = document.querySelector(".msger-chat");

      const BOT_IMG = "../static/images/robo.png";
      const PERSON_IMG = "../static/images/human.png";
      const BOT_NAME = "ChatBot";
      const PERSON_NAME = "You";

      msgerForm.addEventListener("submit", event => {
        event.preventDefault();

        const msgText = msgerInput.value;
        if (!msgText) return;

        appendMessage(PERSON_NAME, PERSON_IMG, "right", msgText);
        msgerInput.value = "";
        botResponse(msgText);
      });

      function appendMessage(name, img, side, text) {
        const msgHTML = `
          <div class="msg ${side}-msg">
            <div class="msg-img" style="background-image: url(${img})"></div>
            <div class="msg-bubble">
              <div class="msg-info">
                <div class="msg-info-name">${name}</div>
                <div class="msg-info-time">${formatDate(new Date())}</div>
              </div>
              <div class="msg-text">${text}</div>
            </div>
          </div>
        `;

        msgerChat.insertAdjacentHTML("beforeend", msgHTML);
        msgerChat.scrollTop += 500;
      }

      function botResponse(rawText) {
        $.get("/get", { msg: rawText }).done(function (data) {
          const msgText = data;
          appendMessage(BOT_NAME, BOT_IMG, "left", msgText);
        });
      }

      function formatDate(date) {
        const h = "0" + date.getHours();
        const m = "0" + date.getMinutes();
        return `${h.slice(-2)}:${m.slice(-2)}`;
      }
    </script>
  </body>
</html>
