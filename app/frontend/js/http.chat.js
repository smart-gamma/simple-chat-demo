class HttpChat {

    displayNewMessage(message) {
        let container = $("#default-messages");
        container.prepend(
            $(this._messageTemplate({ "dateTime": this._moment().format("lll"), "comment": message }))
        );
    }

    sendMessage() {
        let _this = this;
        $.ajax({
            url: this._postUrl,
            async: "false",
            cache: "false",
            type: "POST",
            data: this._form.serialize(),
            success: function(response) {
                _this._form[0].reset();
            }
        });
    }

    constructor(uri, formId, postUrl) {
        let connection = require("stream-http");
        let _this = this;

        this._postUrl = postUrl;
        this._moment = require("moment");
        this._messageTemplate = require("./templates/new_message.hbs");
        this._form = $("#" + formId);

        connection.get(uri, function(res) {
            res.on("data", function(buf) {
                _this.displayNewMessage(buf.toString());
            });
        });

        this._form.on("submit", function(e) {
            e.preventDefault();
            e.stopPropagation();
            _this.sendMessage();

            return false;
        });
    }
}

connect = function(uri, formId, postUrl) {
    new HttpChat(uri, formId, postUrl);
};
