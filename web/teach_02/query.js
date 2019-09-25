$(document).ready(function(){

$("#colorButton").click(function () {
        $(".first").css("background-color", $("#txtColor").val());
    });

$("#fadeButton").click(function () {
        $("#div3").fadeToggle("slow");
    });

});