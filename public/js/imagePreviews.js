
//proof images
function readURL(input) {
    if (input.files && input.files[0] && input.files[0].type) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#preview-image').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#proof").change(function(){
    readURL(this);
});

//review images
$(document).ready(function(){
    $("#reviewImg").change(event => {
        if(event.target.files){
            let amount = event.target.files.length;
            $("#images").html("");

            for (let i = 0; i < amount; i++) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    let html = `
                        <div class="d-flex flex-column col-md-12 position-relative">
                            <button type="button" class="delete-btn btn btn-danger bg-transparent position-absolute border-0" name="delete-btn" style="top:0px; right:0px;">
                                <i class="delete fas fa-times fa-lg" style="color: #f70808;"></i>
                            </button>
                            <img id="preview-image" src="${event.target.result}" class="img-thumbnail border-0 p-2" style="height: 300px; object-fit:contain;">
                        </div>
                    `;
                    $("#images").append(html);
                }
                reader.readAsDataURL(event.target.files[i]);
            }
        }
    });

    $(window).click(function(event){
        if($(event.target).hasClass('delete')) {
            $(event.target).parent().parent().remove();
        }
    });
})
