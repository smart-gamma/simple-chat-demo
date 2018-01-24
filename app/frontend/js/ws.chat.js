class WebSocketChat {

    enterRoom(roomName) {
        let message = {
            room: roomName
        };
        this._connection.send("chatRoomEnter:" + JSON.stringify(message));
    }

    leaveRoom(roomName) {
        let message = {
            room: roomName
        };
        this._connection.send("chatRoomLeave:" + JSON.stringify(message));
    }

    createRoom(roomName) {
        if ($("#room-" + roomName ).length > 0) {
            $('[href="#room-' + roomName + '"]').tab("show");
            return false;
        }

        let tab = require("./templates/new_tab.hbs");
        let tabContent = require("./templates/new_tab_content.hbs");
        $("#room-tabs").append(
            $(tab({ "room": roomName }))
        );
        $("#room-tabs-content").append(
            $(tabContent({ "room": roomName }))
        );

        $('[href="#room-' + roomName + '"]').tab("show");

        this.enterRoom(roomName);

        return true;
    }

    displayNewMessage(message) {
        let messageData;
        try {
            messageData = JSON.parse(message);
        } catch (e) {
            return;
        }

        let container = $("#" + messageData.room + "-messages");
        container.prepend(
            $(this._messageTemplate({ "dateTime": this._moment().format("lll"), "comment": messageData.comment }))
        );
    }

    sendMessage(roomName, comment) {
        let message = {
            room: roomName,
            comment: comment
        };
        this._connection.send("chatMessage:" + JSON.stringify(message));
    }

    constructor(url) {
        this._connection = new WebSocket(url);
        this._moment = require("moment");
        this._messageTemplate = require("./templates/new_message.hbs");

        let that = this;
        this._connection.onopen = function() {
            let init = {
                room:"default"
            };
            that._connection.send("chatRoomEnter:" + JSON.stringify(init));
        };

        this._connection.onmessage = function(event) {
            that.displayNewMessage(event.data);
        };
    }
}

(function($) {
    $.fn.onPressEnter = function(func) {
        this.bind("keypress", function(e) {
            if ( e.keyCode === 13 ) {
                e.preventDefault();
                func.apply(this, [e]);
            }
        });
        return this;
    };
})(jQuery);

connect = function(url) {
    let chat = new WebSocketChat(url);
    let messageInput = $("input#new-message");
    let newRoomInput = $("input#new-room-name");
    let send = function() {
        if ("" === messageInput.val() ) {
            return;
        }
        chat.sendMessage($("li.active").data("chatroom"), messageInput.val());
        messageInput.val(null);
    };

    let newRoom = function() {
        if ("" === newRoomInput.val() ) {
            return;
        }
        chat.createRoom(newRoomInput.val());
        newRoomInput.val(null);
    };

    /**
     * Send message
     */
    messageInput.onPressEnter(function() {
        send();
    });
    $("#btn-send").on("click", function() {
        send();
    });

    /**
     * Create new room
     */
    newRoomInput.onPressEnter( function() {
        newRoom();
    });
    $("#btn-add-room").on("click", function() {
        newRoom();
    });

    /**
     * Remove a Tab
     */
    $("#room-tabs").on("click", " li a .close", function() {
        let roomName = $( this ).parents("li.active").data("chatroom");
        chat.leaveRoom(roomName);

        let tabId = $( this ).parents("li").children("a").attr("href");
        $( this ).parents("li").remove("li");
        $( tabId ).remove();

        $("#room-tabs a:first").tab("show");
    });

    /**
     * Click Tab to show its content
     */
    $("#room-tabs").on("click", "a", function( e ) {
        e.preventDefault();
        $( this ).tab("show");
    });
};
