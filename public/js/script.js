$('.form-item input').keyup(function(e) {
    if(e.target.value === "") {
        $(e.target).removeClass('active');
    } else {
        $(e.target).addClass('active');
    }
});