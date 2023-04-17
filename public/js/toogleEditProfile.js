$(document).ready(function () {
    resetForm();
})

$('[name="edit"]').on('click', function() {
    $(this).css('display','none');
    var input = $(this).prev('input');

    if (!input.is('input')) {
        input = $(this).prev('textarea');
    }

    if(input.attr('name')=='password'){
        $('[name=passwordConfirm]').parent().css('display','block');
    }

    input.attr("readonly", false);
    $('[name=submitBtn]').attr('disabled',false);
});

$('input[type="file"]').change(function(){
    $('[name=submitBtn]').attr('disabled',false);
});

function resetForm(){
    $('[name=passwordConfirm]').parent().css('display','none');
    $('[name=passwordConfirm]').attr('value','');
    $('[name=submitBtn]').attr('disabled',true);
}
