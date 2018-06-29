function send_request(game_id, user) {
    $.post("helper/send_request.php", 
        {"game_id":game_id, "user":user},
        function (data) {
            var alert = $("#request_error");
            alert.addClass("alert-success");
            alert.children("span").text("Richiesta inviata con successo!");
            alert.show();
        }, 
        "json")
    .fail(function (error) {
        console.log(error);
        var alert = $("#request_error");
        alert.addClass("alert-danger");
        alert.children("span").text(error['responseText']);
        alert.show();
    });
};