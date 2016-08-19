function uploadPhoto(){
    showPreloader();
    var file = this.files[0];
    var form = new FormData();
    form.append($(this).attr('name'), file);
    var self = this;

    $.ajax({
        url: uploadUrl,
        type: 'POST',
        contentType: false,
        processData: false,
        data: form,
        success: function(response){
            if(response.error.uploadError !== 0){
                hidePreloader();
                showError(response.error.uploadError);
            }else{
                hidePreloader();
                addThumb(response);
                $(self).val('');
            }

        }
    });
}

function deletePhoto(){
    showPreloader();
    var thumb = $(this).parent();
    var path = $(this).data('path');
    $.ajax({
        url: deleteUrl,
        type: 'POST',
        data: 'path='+path,
        success: function(){
            hidePreloader();
            deleteThumb(thumb);
            var photos = JSON.parse($('#photo-inp').val());
            var newArr = [];
            for(var i = 0; i < photos.length; i++){
                if(photos[i] != path){
                    newArr.push(photos[i]);
                }
            }
            $('#photo-inp').val(JSON.stringify(newArr));
        }
    });
}

function selectCover(){
    var fileName = $(this).attr('src').substr( $(this).attr('src').lastIndexOf('/')+1);
    $('#realty-cover').val(fileName);
    $('#photo-wrap img').removeClass('isCover');
    $(this).addClass('isCover');
}

function addThumb(thumb){
    $('#photo-wrap .alert').hide();
    var photoBox = '<div class="photo-box"><div class="photo-prev"><img src="'+thumb.url+'"></div><button class="btn btn-danger photo-remove" data-path="'+thumb.path+'" type="button"><span class="glyphicon glyphicon-remove"></span></button></div>';
    $('#photo-wrap').append(photoBox);
    $('.photo-box img').click(selectCover);
    $('.photo-box .photo-remove').click(deletePhoto);
    hideError();
}

function deleteThumb(el){
    el.remove();
    if($('#photo-wrap').find('.photo-box').length == 0){
        $('#photo-wrap .alert').show();
    }
    hideError();
}

function showPreloader(){
    $('#preloader').show();
    $('#uploadInp').attr('disabled', 'disabled');
}

function hidePreloader(){
    $('#preloader').hide();
    $('#uploadInp').removeAttr('disabled');
}

function showError(error){
    $('#uploadInpWrap').addClass('has-error').find('.help-block').text(error);
}

function hideError(){
    $('#uploadInpWrap').removeClass('has-error').find('.help-block').text('');
}

$('#uploadInp').change(uploadPhoto);
$('.photo-box img').click(selectCover);
$('.photo-box .photo-remove').click(deletePhoto);
