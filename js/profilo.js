function deleteRequest(id, username) {
    $.post("helper/delete_request.php", 
        {"game_id":id, "user":username},
        function (data) {
            var alert = $("#request_error");
            alert.addClass("alert-success");
            alert.children("span").text("Richiesta eliminata con successo");
            alert.show();
            var req_li = $("#req_"+id);
            req_li.remove();
        }, 
        "json")
    .fail(function (error) {
        console.log(error);
        var alert = $("#request_error");
        alert.addClass("alert-danger");
        alert.text(error);
        alert.show();
    });
}

function deleteGame(id) {
    $.post("helper/delete_game.php", 
        {"game_id":id },
        function (data) {
            var alert = $("#request_error");
            alert.addClass("alert-success");
            alert.children("span").text("Partita eliminata con successo");
            alert.show();
            var req_li = $("#game_"+id);
            req_li.remove();
        }, 
        "json")
    .fail(function (error) {
        console.log(error);
        var alert = $("#request_error");
        alert.addClass("alert-danger");
        alert.text(error);
        alert.show();
    });
}

function acceptRequest(id,user) {
    console.log(id + " - " + user);
    $.post("helper/handle_requests.php", 
        {"game_id":id, 'user':user, 'action':'accept' },
        function (data) {
            var alert = $("#request_error");
            alert.addClass("alert-success");
            alert.children("span").text("Richiesta accettata");
            alert.show();
            var rec_li = $("#rec_"+id+"_"+user);
            rec_li.removeClass("list-group-item-danger");
            rec_li.removeClass("list-group-item-warning");
            rec_li.addClass("list-group-item-success");
        }, 
        "json")
    .fail(function (error) {
        console.log(error);
        var alert = $("#request_error");
        alert.addClass("alert-danger");
        alert.text(error);
        alert.show();
    });
}

function denyRequest(id,user) {
    console.log(id + " - " + user);
    $.post("helper/handle_requests.php", 
        {"game_id":id, 'user':user, 'action':'deny' },
        function (data) {
            var alert = $("#request_error");
            alert.addClass("alert-success");
            alert.children("span").text("Richiesta rifiutata");
            alert.show();
            var rec_li = $("#rec_"+id+"_"+user);
            rec_li.removeClass("list-group-item-success");
            rec_li.removeClass("list-group-item-warning");
            rec_li.addClass("list-group-item-danger");
        }, 
        "json")
    .fail(function (error) {
        console.log(error);
        var alert = $("#request_error");
        alert.addClass("alert-danger");
        alert.text(error);
        alert.show();
    });
}