$(function(){
    const $navbar = $('.navbar');


    $("#search_input_box").hide();
    $("#search_1").on("click", function () {
        if ($("#search_input_box").is(":hidden")) {
            $("#search_input_box").slideDown(300, function() {
                $("#search_input").focus();
            });
        } else {
            $("#search_input_box").slideUp(300);
        }
    });

    $("#close_search").on("click", function () {
        $("#search_input_box").slideUp(300);
        $("#contentHolder").stop(true).animate({ "padding-top": "0px" }, 300);
    });


    if ($navbar.length) {
        function updateNavbarStyles() {
            if ($(window).scrollTop() > 50) {
                $navbar.addClass('navbar-scrolled').removeClass('navbar-desktop');
            } else {
                $navbar.removeClass('navbar-scrolled');
                if ($(window).width() >= 1400) {
                    $navbar.addClass('navbar-desktop');
                } else {
                    $navbar.removeClass('navbar-desktop');
                }
            }
        }

        $(document).on('scroll', updateNavbarStyles);

        $(window).on('resize', updateNavbarStyles);

        updateNavbarStyles();
    }










});
