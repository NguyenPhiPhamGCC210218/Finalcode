const ChatController = {
  socket: null,
  socket_id_sender: null,
  user_token: null,
  receiver: null,
  EventListener() {
    $(".user-chat").click(function () {
      if ($(".sidebar").hasClass("open")) {
        $(".sidebar").removeClass("open");
      }
      ChatController.SelectUserChat(this);
    });

    $("#content_form").submit(function (e) {
      e.preventDefault();
      const payload = {
        to_user_id: ChatController.receiver,
        content: $("#content_message").val(),
      };
      ChatController.socket.emit("CHAT", payload);
      $("#content_message").val("");
    });
  },
  SelectUserChat(_this) {
    ChatController.receiver = $(_this).data("user-id");
    console.log(ChatController.receiver);

    $(`#has_mess_user_id_${ChatController.receiver}`).addClass(
      "visually-hidden"
    );
    ChatController.LoadChatData(ChatController.receiver, UpdateUI);
    function UpdateUI() {
      const full_name = $(_this).data("user-full-name");

      $("#chat_container").removeClass("visually-hidden");
      // $("#bg_default_chat").addClass("visually-hidden");
      $(".user-chat").removeClass("active");
      $(_this).addClass("active");

      $("#name_current_user").html(full_name);
    }
  },
  LoadChatData(receiver, callback) {
    fetch(
      `http://localhost:1000/management/get_chat_data.php?cust_id=${receiver}`
    )
      .then(async (res) => {
        const data = await res.json();

        if (data.status_code !== 200) {
          alert("Something went wrong!");
          return;
        }

        callback();
        if (data.chat_list) {
          ChatController.RenderMessageData(data.chat_list);
        }
      })
      .catch((e) => {
        console.log(e);
        alert("Something went wrong!");
      });
  },
  RenderMessageData(chat_list) {
    let total_chat = "";
    chat_list.map((chat) => {
      let time = new Date(chat.date);
      time = [
        String(time.getHours()).padStart(2, "0"),
        String(time.getMinutes()).padStart(2, "0"),
      ].join(":");
      let chat_html = `<li class="chat-right">
                                <div class="chat-hour">${time}</div>
                                <div class="chat-text" style="background: black; color: white">${chat.content}</div>
                                </li>`;

      if (chat.sender != -1) {
        chat_html = `<li class="chat-left">
                                    <div class="chat-text" style="background: #012970; color: white">
                                        ${chat.content}
                                    </div>
                                    <div class="chat-hour">${time}</div>
                                </li>`;
      }

      total_chat += chat_html;
    });
    $(".chat-box").empty();
    $(".chat-box").append(total_chat);
    $(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);
  },
  ConnectRealtimeServer() {
    ChatController.socket = io("http://localhost:3000", {
      transports: ["websocket"],
      upgrade: true,
      auth: { token: ChatController.user_token },
    });
  },
  RealtimeListener() {
    ChatController.socket.on("connect", function () {
      console.log("connected - socket id: ", ChatController.socket.id);
      ChatController.socket_id_sender = ChatController.socket.id;

      ChatController.socket.on("CHAT", function (data) {
        console.log(data);
        console.log(ChatController.receiver);
        if (data.sender_id == ChatController.receiver || data.sender_id == -1) {
          ChatController.RenderMessageRealtime(data);
        }
        if (
          data.sender_id !== -1 &&
          data.sender_id != ChatController.receiver
        ) {
          $(`#has_mess_user_id_${data.sender_id}`).removeClass(
            "visually-hidden"
          );
        }
      });
    });

    ChatController.socket.on("connect_error", function (error) {
      ChatController.socket.removeAllListeners();
      if (error.message === "unauthorized") {
        console.log("unauthorized");
      }
    });

    ChatController.socket.on("reconnect", function (number) {
      console.log("number");
      console.log("reconnect");
    });

    ChatController.socket.on("disconnect", function (reason) {
      ChatController.socket.removeListener("chat:message");
      console.log(reason);
    });
  },
  RenderMessageRealtime(data) {
    let time = new Date(data.date);
    time = [
      String(time.getHours()).padStart(2, "0"),
      String(time.getMinutes()).padStart(2, "0"),
    ].join(":");
    let message_html = `<li class="chat-right">
                                <div class="chat-hour">${time}</div>
                                <div class="chat-text" style="background: black; color: white">${data.content}</div>
                                <div class="chat-avatar">
                                </div>
                                </li>`;

    if (data.to_user_id == -1) {
      message_html = `<li class="chat-left">
                                    <div class="chat-text" style="background: #012970; color: white">
                                        ${data.content}
                                    </div>
                                    <div class="chat-hour">${time}</div>
                                </li>`;
    }

    $(".chat-box").append(message_html);
    $(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);
  },
  GetTokenFromCookie(cname) {
    return $.cookie(cname);
  },
  Run() {
    ChatController.user_token = $.cookie("user_token");
    if (ChatController.user_token !== undefined) {
      ChatController.ConnectRealtimeServer();
      ChatController.RealtimeListener();
      ChatController.EventListener();
    }
  },
};

$(document).ready(function () {
  ChatController.Run();
});
