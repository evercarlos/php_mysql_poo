$(function () {
    $.fn.required = function () {
        if ($(this).val() === '' || $(this).val() === null) {
            $(this).addClass('border-red').focus();
            return false;
        } else {
            $(this).removeClass('border-red');
            return true;
        }
    };
})