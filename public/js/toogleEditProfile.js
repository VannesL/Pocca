$(document).ready(function () {
    resetForm();
})

$('[name="edit"]').on('click', function() {
    $(this).css('display','none');
    var input = $(this).prev('input');
    if(input.attr('name')=='password'){
        $('[name=passwordConfirm]').parent().css('display','block');
    }
    input.attr("readonly", false);
    $('[name=submitBtn]').css('display','block');
});

function resetForm(){
    // $('[name=passwordConfirm]').parent().css('display','none');
    // $('[name=passwordConfirm]').attr('value','');
    $('[name=submitBtn]').css('display','none');
}