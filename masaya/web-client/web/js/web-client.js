/**
 * 読み込み完了
 */
$(document).ready(function () {
    reloadMessages();
});

/**
 * 投稿
 */
$(".post-message").bind("click", function() {
    $("#myModal").modal("hide");
    var body = $(".message-body").val();
    var uname = $(".message-uname").val();
    var icon = $globalImage.replace( "data:image/jpeg;base64," , "" );


    sendMessage(uname, body, icon);
});

/**
 * 画像選択
 */
$("#image-form").change(function () {
    if (!this.files.length) {
        return;
    }

    var file = this.files[0];
    var fileReader = new FileReader();
    fileReader.readAsDataURL(file);

    fileReader.onload = function() {
        var image = new Image();

        $globalImage = this.result;

        image.src = this.result;
        insertImage(image);
    }
});

/**
 * 画像挿入
 */
function insertImage(image) {
    $(".image-result").html('<img src="' + image.src + '" width="60">');
}




