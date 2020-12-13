$(document).on('keyup', '.form-item input', function(e) {
    if(e.target.value === "") {
        $(e.target).removeClass('active');
    } else {
        $(e.target).addClass('active');
    }
});

$( document ).ready(function() {
    $('.form-item input').each(function(i, obj) {
        if($(obj).val() === "") {
            $(obj).removeClass('active');
        } else {
            $(obj).addClass('active');
        }
    });
});