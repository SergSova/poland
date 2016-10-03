function createSlider(a){var b=$("#"+a.id),c=b.val().indexOf(";");b.val().substring(0,c);b.val().substring(c+1);return b.ionRangeSlider({type:a.type,min:a.min,max:a.max,postfix:a.postfix})};
