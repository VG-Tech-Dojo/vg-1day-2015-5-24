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
function sendMessage(username, body) {
    var success = function() {
        $(".message-body").val("");
        reloadMessages();
    };
    var error   = function() { console.log("error") };
    postMessage(username, body, success, error);
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
 * 2桁にゼロ埋め
 */
var toDoubleDigits = function(num) {
  num += "";
  if (num.length === 1) {
    num = "0" + num;
  }
 return num;     
};

/**
 * 日付のフォーマット
 */
var formatDate = function(date) {
  var yyyy = date.getFullYear();
  var mm = toDoubleDigits(date.getMonth() + 1);
  var dd = toDoubleDigits(date.getDate());
  var hh = toDoubleDigits(date.getHours());
  var mi = toDoubleDigits(date.getMinutes());
  var sec = toDoubleDigits(date.getSeconds());
  return yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + mi + ':' + sec;
};

/**
 * メッセージ挿入
 */
function appendMessage(message) {
	var escapeUsername = $("<div/>").text(message.username).html();
	var escapeBody = $("<div/>").text(message.body).html();
	var escapeIcon = $("<div/>").text(message.icon).html();
	var escapeCreatedAt = $("<div/>").text(formatDate(new Date(message.created_at))).html();

    var messageHTML = '<tr><td>' +
        '<div class="media message">'　+
	    '<div>' +
        escapeUsername +
	    '</div>' +
        '<div class="media-left" id="top-aligned-media">' +
        '<img class="media-object" src="data:image/png;base64,' + escapeIcon + '" data-holder-rendered="true" style="width: 64px; height: 64px;">' +
        '</div>' +
        '<div class="media-body">' +
        '<h4 class="media-heading"></h4>' +
        escapeBody +
	    '</div>' +
	    '<div>' +
        escapeCreatedAt +
	    '</div>' +
        '</div>' +
        '</td></tr>';
	$("#message-table").append(messageHTML);
}

/**
 * APIリクエストコメント取得
 */
function getMessages(success, error) {
    var getMessageUri = "http://localhost:8888/messages";
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
function postMessage(username, body, success, error) {
    var postMessageUri = "http://localhost:8888/messages";
    return $.ajax({
        type: "post",
        url: postMessageUri,
        data: JSON.stringify({"username":username, "body":body}), 
        dataType: "json",
        })
    .done(function(data) { success() })
    .fail(function() { error() });
}
