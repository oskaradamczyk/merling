$(document).ready(function () {
    load($('#document-progress-bar'), 15);
    parallaxAll($('.parallax-window'));
    $('body').removeClass('opacity02');
    fadeInAndOut($('.on-hover-fade'));
    $('.on-ready-fade').each(function () {
        $(this).fadeIn(100);
    });
});

function parallaxAll(selector) {
    selector.each(function () {
        $(this).parallax({
            imageSrc: $(this).data('data-image-src'),
            overScrollFix: true,
            speed: 0.0
        })
    })
}

function fadeInAndOut(selector, inAction = 'mouseleave', outAction = 'mouseenter') {
    selector.each(function () {
        if (inAction !== null) {
            $(this).on(inAction, function () {
                $(this).removeClass('opacity0');
            });
        } else {
            $(this).removeClass('opacity0');
        }
        if (outAction !== null) {
            $(this).on(outAction, function () {
                $(this).addClass('opacity0');
            })
        }
    })
}

function load(element, delay = 10) {
    let width = 1;
    let id = setInterval(frame, delay);

    function frame() {
        if (width >= 100) {
            clearInterval(id);
        } else {
            width++;
            element.css('width', width + '%');
        }
    }
}