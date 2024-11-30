const ChatController = {
  socket: null,
  user_id: null,
  user_token: null,
  receiver: null,
  is_login: false,
  ConnectSocketServer() {
    ChatController.socket = io("http://localhost:3000", {
      transports: ["websocket"],
      upgrade: true,
      auth: { token: ChatController.user_token },
    });
  },
  SetUpSocketEvent() {
    ChatController.socket.on("connect", function () {
      console.log("connected id::", ChatController.socket.id);
      ChatController.socket.on("CHAT", function (data) {
        ChatController.RenderMessageRealtime(data);
      });
    });
    ChatController.socket.on("connect_error", function (error) {
      ChatController.socket.removeAllListeners();
      if (error.message === "unauthorized") {
        console.log("unauthorized");
      }
    });

    ChatController.socket.on("reconnect", function (number) {
      console.log("reconnect::", number);
    });

    ChatController.socket.on("disconnect", function (reason) {
      ChatController.socket.removeListener("chat:message");
      console.log("disconnect::", reason);
    });
  },
  RenderMessageRealtime(data) {
    console.log(data);
    let time = new Date(data.date);
    time = [time.getDate(), time.getMonth() + 1, time.getFullYear()].join("-");
    let message_html = `<div>
                            <div class="message d-inline-block">
                                <div style="text-align: end">
                                    <div  class="text_chat">
                                        ${data.content}
                                    </div>
                                    <p style="margin-bottom: 0;text-align: end;font-size: 11px">${time}</p>
                                </div>
                            </div>
                        </div>`;

    if (data.to_user_id != ChatController.user_id) {
      message_html = `<div style="text-align: end">
                            <div class="message message-right d-inline-block">
                                <div style="text-align: end">
                                    <div  class="text_chat">
                                         ${data.content}
                                    </div>
                                    <p style="margin-bottom: 0;text-align: start;color: white; font-size: 11px">${time}</p>
                                </div>
                            </div>
                        </div>`;
    }

    $("#chat_box").append(message_html);
    $("#chat_box").scrollTop($("#chat_box")[0].scrollHeight);
  },
  EvenListener() {
    $("#btn_toggle_chat_box").click(function () {
      if ($(".chat").hasClass("open-chat-box")) {
        $(".chat").removeClass("open-chat-box");
        $(".chat").addClass("close-chat-box");
        $("#icon_toggle_chat_box").css("rotate", "0deg");
      } else {
        $(".chat").removeClass("close-chat-box");
        $(".chat").addClass("open-chat-box");
        $("#icon_toggle_chat_box").css("rotate", "180deg");
      }
    });

    $("#chat_form").submit(function (e) {
      e.preventDefault();
      if (!ChatController.is_login) {
        alert("you must be login to chat");
        return;
      }
      const payload = {
        content: $("#input_chat").val(),
        to_user_id: -1,
      };
      ChatController.socket.emit("CHAT", payload);
      $("#input_chat").val("");
    });
  },
  LoadChat() {
    const user_id = $.cookie("user_id");
    fetch(
      `http://localhost:1000/management/get_chat_data.php?cust_id=${user_id}`
    )
      .then(async (res) => {
        const data = await res.json();
        if (data.status_code !== 200) {
          alert("Something went wrong! Load chat failt");
          return;
        }
        if (data.chat_list) {
          ChatController.RenderChat(data.chat_list);
        }
      })
      .catch((e) => {
        console.log(e);
        alert("Something went wrong! Load chat failt");
      });
  },
  RenderChat(chat_list) {
    let total_messages = "";
    chat_list.map((chat) => {
      console.log(chat);

      let time = new Date(chat.date);
      time = [
        String(time.getHours()).padStart(2, "0"),
        String(time.getMinutes()).padStart(2, "0"),
      ].join(":");
      let message_html = `<div>
        <div class="message d-inline-block">
            <div style="text-align: end">
                <div  class="text_chat">
                    ${chat.content}
                </div>
                <p style="margin-bottom: 0;text-align: end;font-size: 11px">${time}</p>
            </div>
            </div>
        </div>`;

      if (chat.sender == ChatController.user_id) {
        message_html = `<div style="text-align: end">
              <div class="message message-right d-inline-block">
                  <div style="text-align: end">
                      <div  class="text_chat">
                          ${chat.content}
                      </div>
                      <p style="margin-bottom: 0;text-align: start;color: white; font-size: 11px">${time}</p>
                  </div>
              </div>
          </div>`;
      }
      total_messages += message_html;
    });
    $("#chat_box").append(total_messages);
    $("#chat_box").scrollTop($("#chat_box")[0].scrollHeight);
  },
  Run() {
    ChatController.EvenListener();
    ChatController.user_token = $.cookie("user_token");
    console.log($.cookie("user_token"));
    console.log($.cookie("user_id"));
    if (!ChatController.user_token) {
      return;
    }

    ChatController.user_id = $.cookie("user_id");
    ChatController.LoadChat();
    ChatController.is_login = true;
    ChatController.ConnectSocketServer();
    ChatController.SetUpSocketEvent();
  },
};

$(document).ready(function () {
  ChatController.Run();
});
