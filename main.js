$(function () {

    window.onload = function () {
        var nav = document.getElementById('nav-wrapper');
        var hamburger = document.getElementById('js-hamburger');
        var blackBg = document.getElementById('js-black-bg');

        hamburger.addEventListener('click', function () {
            nav.classList.toggle('open');
        });
        blackBg.addEventListener('click', function () {
            nav.classList.remove('open');
        });
    };



    function fadeAnime() {
        $('.element').each(function () { 
            var elemPos = $(this).offset().top - 50; 
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll >= elemPos - windowHeight) {
                $(this).addClass('fadeUp');
                
            } else {
                $(this).removeClass('fadeUp');
                
            }
        });

        $('.fadeDownTrigger').each(function () { 
            var elemPos = $(this).offset().top - 50; 
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll >= elemPos - windowHeight) {
                $(this).addClass('fadeDown');
                
            } else {
                $(this).removeClass('fadeDown');
                
            }
        });

    }

    $(window).scroll(function () {
        fadeAnime();
    });
})
