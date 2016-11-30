(function($){

var socket = io('http://127.0.0.1:3000');
console.log(socket);
handleChatSockets();

function handleChatSockets() {
      socket.on("connection", function(data) {
        console.log("Mirko");
      });
      getAllChats(openIndividualChatSocket);

}

function getAllChats(callback) {
  $.ajax({
    url: '/getallchats',
    type: 'POST',
    data: {
      _token: returnCSRFtoken()
    },
    dataType: 'JSON',
    success: function(data) {
      callback(data);
    }
  })
}

function openIndividualChatSocket(chats) {
  $.each(chats, function(index, chat) {
    socket.on("chat."+chat.id+":App\\Events\\NewMessage", function(message) {
      appendMessageToChat(message.user.id, message.message);
      console.log("Chat socket opened at: "+"chat."+chat.id+":App\\Events\\NewMessage"); 
    });
  });
}


// Just returns CSRF token set in head
function returnCSRFtoken() {
  return $('meta[name="csrf-token"]').attr('content');
}

function handleOpenChat(chat) {
  removePreviousConversation();
  createForm(chat);
  createFileUploadForm(chat);
  fillWithCurrentConversation(chat);
}

function createFileUploadForm(chat) {
  var form = "<div id='fileuploader'>Upload</div>";
  $("#send-message-section").append(form);
  $("#fileuploader").uploadFile({
    url: '/uploadattachment',
    dragDrop: false,
    multiple: false,
    allowedTypes: 'txt',
    showStatusAfterSuccess: false,
    showProgress: false,
    formData: { 
      _token: returnCSRFtoken(),
      other_user: chat.other_user
    }
  });
}

function createForm(chat) {
  var form = "<form id='send-message-form' name='new-message-form' method='POST'>" +
               "<input type='hidden' id='with_user' value='"+chat.other_user+"' />" +
               "<input type='text' id='content' class='' />" +
               "<button id='send-message-button'>Send</button>" +
             "</form>";
  $("#send-message-section").append(form);
}

function appendMessageToChat(current_user_id, message) {
  // TODO: handle exceptions redirect and such if no user
  var message_class = "message-other";
  var sender = $("#other_user_email").val();
  if($("#current_user_id").val() == message.user_id) {
    message_class = "message-me";
    sender = "Me";
  }
  var html = "<div class='"+message_class+"'><span><b>"+sender+": </b></span>"+message.content+"</div>"
  $("#messages").append(html);
}

function fillWithCurrentConversation(chat) {
  $.each(chat.chat_history, function(key, message) {
    if(typeof message === 'object')
      appendMessageToChat(chat.current_user, message); 
  })
}

function removePreviousConversation() {
  $("#messages").html("");
  $("#send-message-section").html("");
}

function openChatWith(userId, userEmail, callback) {
  $("#other_user_email").val(userEmail);
  $("#chating-with").text(userEmail);
  $("#private-chat-with").text(userEmail);
  $("#chat-space").show();
  $.ajax({
    url: '/open/private',
    type: 'POST',
    data: {
      _token: returnCSRFtoken(),
      with_user: userId
    },
    dataType: 'JSON',
    success: function(data) {
      callback(data);
    }
  })
}

function sendMessage()
{

  $.ajax({
    url: '/sendmessage',
    type: 'POST',
    data: {
      user: $("#with_user").val(),
      content: $("#content").val(),
      _token: returnCSRFtoken()
    },
    dataType: 'JSON',
    success: function(data) {
        removeInputData();
    }
  })
}

function removeInputData() {
  $("#content").val("");
}


//----------//
//- EVENTS -//
//----------//
$(".people").bind("click", function(e) {
  openChatWith($(this).data("id"), $(this).data("email"), handleOpenChat);
});

$("#send-message-section").on("click", "button",  function(e) {
  e.preventDefault();
  sendMessage();
});


})(jQuery)
