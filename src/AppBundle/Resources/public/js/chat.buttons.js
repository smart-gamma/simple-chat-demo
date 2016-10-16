(function($) {
    $.fn.onEnter = function(func) {
        this.bind('keypress', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                func.apply(this, [e]);
            }
        });
        return this;
    };
})(jQuery);

function sendMessage() {
    var messageInput = $("input#new-message");
    if ('' === messageInput.val()) {
        return;
    }

    sendChatMessage($('li.active').data('chatroom'), messageInput.val());
    messageInput.val(null);
}

function createRoom() {
    var newRoomInput = $("input#new-room-name");
    if ('' === newRoomInput.val()) {
        return;
    }

    createChatRoom(newRoomInput.val());
    newRoomInput.val(null);
}

$(document).ready(function() {

    var messageInput = $("input#new-message");
    messageInput.onEnter( function() {
        sendMessage();
    });

    var newRoomInput = $("input#new-room-name");
    newRoomInput.onEnter( function() {
        createRoom();
    });

    $("#btn-send").on('click', function (e) {
        sendMessage();
    });

    $("#btn-add-room").on('click', function (e) {
        createRoom();
    })
});

    