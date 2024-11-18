$(function(){

    $("#search_input_box").hide();
    $("#search_1").on("click", function () {
        $("#search_input_box").slideToggle(300, function() { // Increase the duration to make it smoother
            $("#search_input").focus();
        });
        $("#contentHolder").animate({ "padding-top": "50px" }, 300); // Use animate() for smoother padding change
    });

    $("#close_search").on("click", function () {
        $("#search_input_box").slideUp(300); // Slow down slide up as well for consistency
    });





});