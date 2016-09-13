$('.slick-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    draggable: true,
    swipe: true,
    lazyLoad: 'ondemand',
    prevArrow: '<button class="btn-floating mypallete slick-prev"><i class="material-icons">chevron_left</i></button>',
    nextArrow: '<button class="btn-floating mypallete slick-next"><i class="material-icons">chevron_right</i></button>',
    mobileFirst: true,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                arrows: false,
                swipe: false,
            }
        }
    ]
});
$('.slick-nav').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    dots: false,
    prevArrow: '<button class="btn-floating mypallete slick-prev"><i class="material-icons">chevron_left</i></button>',
    nextArrow: '<button class="btn-floating mypallete slick-next"><i class="material-icons">chevron_right</i></button>',
    asNavFor: '.slick-for',
    focusOnSelect: true,
    vertical: false,
    adaptiveHeight: true,
    mobileFirst: true,
    responsive: [
        {
            breakpoint: 992,
            settings: {
                vertical: true,
                prevArrow: '<button class="btn-floating mypallete slick-prev"><i class="material-icons">expand_less</i></button>',
                nextArrow: '<button class="btn-floating mypallete slick-next"><i class="material-icons">expand_more</i></button>',
            }
        }
    ]
});

$('.modal-trigger').leanModal();
$('.close-modal-but').click(function () {
    $($(this).data('target')).closeModal();
});
$('#callback-form-wrap').on("pjax:start", function(){
    $(this).find('.preloader').show();
});
$('#feedback-form-wrap').on("pjax:start", function(){
    $(this).find('.preloader').show();
})



