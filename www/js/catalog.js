$("select").material_select();
if($(window).height() > $('#filter-box').height() + $('#filter-box').offset().top){
    $('#filter-box .filter-box').pushpin({
        top: $('#filter-box').offset().top,
        offset: $('#filter-box').offset().top,
        bottom: $('body').height() - $('#filter-box').height()
    });
}


$("#showFilter").sideNav({
    menuWidth: 320,
    edge: 'right'
});
function updateData(){
    $.pjax.reload({container:"#realty-list"});
    $("select").material_select();
    for(var i = 0; i < slidersSettings.length; i++){
        createSlider(slidersSettings[i]);
    }
}
$("#house-filter").on("pjax:end", updateData);
$("#apartment-filter").on("pjax:end", updateData);
$("#mobile-house-filter").on("pjax:end", function() {
    $("#showFilter").sideNav('hide');
    updateData();
});
$("#mobile-apartment-filter").on("pjax:end", function() {
    $("#showFilter").sideNav('hide');
    updateData();
});