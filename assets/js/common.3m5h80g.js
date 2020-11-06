$(function() {
    $("#form-language").on("change", change_function);
    $("#form-function").on("change", change_options);
    $("#form-password").on("change", get_hash).on("keyup", get_hash)
    $("#form-container > form").on("submit", function(e){
        e.preventDefault();
    });
    $("#form-option").on("change", get_hash);
});

var prev_val = ""

function change_function(){
    prev_val = "";

    var url = $("#form-container > form").attr("action");
    var formData = {"action": "getFunctions", "language": $("#form-language").val()};

    $.post(url, formData).done(function (data) {
        if(data == "err" || data == ""){
            $("#form-output").text("An error occured, try again later..");
        } else {
            var arr = data.split(",");
            $("#form-function").html("");

            arr.forEach(element => {
                $("#form-function").append("<option value='" + element + "'>" + element + "</option>");
            });

            $("#form-function").trigger("change");
        }
    });
}

function change_options(){
    prev_val = "";

    var url = $("#form-container > form").attr("action");
    var formData = {"action": "getOptions", "function": $("#form-function").val()};

    $.post(url, formData).done(function (data) {
        if(data == "err" || data == ""){
            $("#form-output").text("An error occured, try again later..");
        } else {
            var arr = data.split(",");
            $("#form-option").html("");

            arr.forEach(element => {
                $("#form-option").append("<option value='" + element + "'>" + element + "</option>");
            });

            $("#form-option").trigger("change");
        }
    });
}

function get_hash(){
    var url = $("#form-container > form").attr("action");
    var formData = $("#form-container > form").serializeArray();
    formData.push({"name": "action", "value": "getPwd"})

    var cur_val = $("#form-password").val() + ":" + $("#form-option").val();

    if(cur_val != prev_val){
        prev_val = cur_val;

        $.post(url, formData).done(function (data) {
            if(data == "err"){
                $("#form-output").text("An error occured, try again later..");
            } else {
                $("#form-output").text(data);
            }
        });
    }
}

function copyText(){
    $("#form-output").select();
    document.execCommand("copy");
}