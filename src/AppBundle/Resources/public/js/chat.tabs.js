$(document).ready(function() {

    /**
     * Add a Tab
     */
    $('#btn-add-room').click(function() {
        var roomName = $('#new-room-name').val();
        if (roomName === '') {
            return;
        }
        if ($('#room-'+roomName).length > 0 ) {
            $('[href="#room-'+roomName+'"]').tab('show');
            return;
        }
        $('#room-tabs').append(
            $('<li><a href="#room-' + roomName + '">' +
                roomName +
                '<button class="close" type="button" ' +
                'title="Leave this room"><i class="glyphicon glyphicon-remove"></i></button>' +
                '</a></li>'));

        $('#room-tabs-content').append(
            $('<div class="tab-pane fade in" id="room-' + roomName +'">' +
                '<div class="room-messages" id="' + roomName + '-messages">' +
                '<small>Messages from '+ roomName +'</small>' +
                '</div>' +
                '</div>'));

        $('[href="#room-'+roomName+'"]').tab('show');
    });

    /**
     * Remove a Tab
     */
    $('#room-tabs').on('click', ' li a .close', function() {
        var tabId = $(this).parents('li').children('a').attr('href');
        $(this).parents('li').remove('li');
        $(tabId).remove();

        $('#room-tabs a:first').tab('show');
    });

    /**
     * Click Tab to show its content
     */
    $("#room-tabs").on("click", "a", function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
