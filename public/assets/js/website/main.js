$(window).on('load',function(){
    var pre_loader = $('#preloader')
pre_loader.fadeOut('slow',function(){$(this).remove();});
});
var btn = $('#backToTop');
$(window).on('scroll', function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
});
btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
        scrollTop: 0
    }, '300');
});

$("#search-btn").on('click', function() {

    $("body").toggleClass("search-form-open");
    $(".search-form-area").toggleClass("fadeIn");
    $(".sear-btn").toggleClass("fadeIn");
    $('.close').toggleClass("fadeIn");
});


 
 