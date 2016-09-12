$("select").material_select();
$('#filter-box .filter-box').pushpin({
    top: $('#filter-box').offset().top,
    offset: $('#filter-box').offset().top
});

$("#showFilter").sideNav({
    menuWidth: 320,
    edge: 'right'
});