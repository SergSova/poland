function createSlider(obj) {
    var sliderInp = $('#'+obj.id);
    var delimPos = sliderInp.val().indexOf(';');
    var min = sliderInp.val().substring(0, delimPos);
    var max = sliderInp.val().substring(delimPos + 1);

    return sliderInp.ionRangeSlider({
        type: obj.type,
        min: obj.min,
        max: obj.max,

        postfix: obj.postfix
    });
}
