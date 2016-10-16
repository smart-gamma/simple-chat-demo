function enterChatRoom(roomName) {
    var message = {
        room:roomName
    };
    connection.send("chatRoomEnter:"+JSON.stringify(message));
}

function sendChatMessage(roomName, comment) {
    var message = {
        room: roomName,
        comment: comment
    };
    connection.send('chatMessage:'+JSON.stringify(message));
}

function leaveChaRoom(roomName) {
    var message = {
        room:roomName
    };
    connection.send("chatRoomLeave:"+JSON.stringify(message));
    
}

function dispatchNewMessage(data)
{

}

function displayNewMessage(message) {
    try {
        var data = JSON.parse(message);
    } catch (e) {
        console.log('Non JSON message: '+ message);
        return;
    }

    var container = $('#'+data.room+'-messages');

    container.prepend(
        $(
            '<div class="panel panel-default">' +
            '<div class="panel-heading">' + new Date().toLocaleString() +
            '</div>' +
            '<div class="panel-body">' +
            data.comment +
            '</div></div>'
        )
    );
}
