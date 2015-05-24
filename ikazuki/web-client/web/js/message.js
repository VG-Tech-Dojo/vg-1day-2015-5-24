/**
 * メッセージリストの読み込み
 */
function reloadMessages() {
    var success = function(data) { appendMessages(data) };
    var error   = function() { console.log("error") };
    getMessages(success, error);
}

/**
 * メッセージの投稿
 */
function sendMessage(body) {
    var success = function() {
        $(".message-body").val("");
        reloadMessages();
    };
    var error   = function() { console.log("error") };
    postMessage(body, success, error);
}

/**
 * メッセージリスト挿入
 */
function appendMessages(data) {
    $("#message-table").empty();
    for ( var i = 0; i < data.length; i++ ) {
        var object = data[i];
        appendMessage(object);
    }
}

/**
 * メッセージ挿入
 */
function appendMessage(message) {
	var escapeBody = $("<div/>").text(message.body).html();
	var escapecreated = $("<div/>").text(message.created_at).html();
        var escapeusername = $("<div/>").text(message.username).html();
	var escapeIcon = $("<div/>").text(message.icon).html();

    var messageHTML = '<tr><td>' +
        '<div class="media message">'　+
        '<div class="media-left" id="top-aligned-media">' +
        '<img class="media-object" src="data:image/png;base64,' + escapeIcon + '" data-holder-rendered="true" style="width: 64px; height: 64px;">' +
        '</div>' +
        '<div class="media-body">' +
        '<h4 class="media-heading"></h4>' + escapeusername + "<br>" +
        escapeBody + "<br>" +escapecreated
	    '</div>' +
        '</div>' +
        '</td></tr>';
	$("#message-table").append(messageHTML);
}

/**
 * APIリクエストコメント取得
 */
function getMessages(success, error) {
    var getMessageUri = "http://133.242.227.15/messages";
    return $.ajax({
        type: "get",
        url: getMessageUri,
        })
    .done(function(data) { success(data) })
    .fail(function() { error() });
}

/**
 * APIリクエストコメント投稿
 */
function postMessage(body, success, error) {
    var postMessageUri = "http://133.242.227.15/messages";
    return $.ajax({
        type: "post",
        url: postMessageUri,
        data: JSON.stringify({"username":body.username, "body":body.message}), 
        dataType: "json",
        })
    .done(function(data) { success() })
    .fail(function() { error() });
}
