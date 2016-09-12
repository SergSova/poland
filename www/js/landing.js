function scrollTo(id){
    $('html, body').animate({
        scrollTop: $(id).offset().top-60
    }, 1000, 'linear');
}
$('.scrollTo').click(function(event){
    event.preventDefault();
    var link = $(this).find('a').attr('href');
    var anchor = link.substr(link.indexOf('#'));
    scrollTo(anchor);
    if($(this).parent().parent().is('#general-menu')){
        $('#general-menu li').removeClass('active');
        $(this).parent().addClass('active');
    }
});
$('.scrollDown').click(function () {
    var anchor = $(this).data('target');
    scrollTo(anchor);
});
$(window).scroll(function(){
    var arr = [];
    var collection = $('.scrollspy');
    var activeElId;
    collection.each(function(){
        if($(this).offset().top < $(window).scrollTop()+70){
            arr.push($(this).attr('id'))
        }
    });
    activeElId = arr[arr.length - 1];
    for(var i = 0; i < $('#general-menu a').length; i++){
        $('#general-menu li').removeClass('active');
        $('#general-menu a'+'[href*="#'+activeElId+'"]').parent().addClass('active');
    }
});

if(location.href.indexOf('#') == -1){
    $('#general-menu li').removeClass('active');
}else{
    $('#general-menu li').removeClass('active');
    var anchor = location.href.substr(location.href.indexOf('#'));
    $('#general-menu a'+'[href*="'+anchor+'"]').parent().addClass('active');
}

$('#scrollbar').myScrollBar({
    class: 'changed',
    color: 'rgb(46, 124, 176)'
});
$('.scrollspy').scrollSpy();
$("select").material_select();
$('.fullHeight').fullHeight({offset: 60});
$('.tooltipped').tooltip();

$('#service-call-button').click(function(event){
    Materialize.toast('Ваша заявка обрабатывается', 4000);
    $('#service-call-inp').attr('disabled', 'disabled');
    $(this).attr('disabled', 'disabled');
    $.ajax({
        url: '/site/service-call',
        method: 'POST',
        data: $('#service-call-inp').attr('name')+'='+$('#service-call-inp').val(),
        success: function(response){
            if(response){
                Materialize.toast('Ваша заявка принята, мы свяжемся с Вами в ближайшее время', 4000);
                $('#service-call-inp').removeAttr('disabled');
                $('#service-call-button').removeAttr('disabled');
            }else{
                Materialize.toast('Введите корректный номер телефона!', 4000);
                $('#service-call-inp').removeAttr('disabled');
                $('#service-call-button').removeAttr('disabled');
            }
        }
    })
});

$('#sendMail-form').submit(function(event){
    event.preventDefault();
    if($(this).yiiActiveForm('data').validated){
        var self = this;
        var formData = '';
        $(self).find('input,textarea').each(function(){
            formData += $(this).attr('name')+'='+$(this).val()+'&';
        });
        formData = formData.slice(0, -1);
        $.ajax({
            url: $(self).attr('action'),
            method: 'POST',
            dataType: 'json',
            data: formData,
            success: function(result){
                Materialize.toast(result['message'], 4000);
                console.log(result['message'])
            }
        })
    }

});