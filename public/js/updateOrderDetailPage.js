$(document).ready(function () {
    updateOrderDetails();
})

function updateOrderDetails() {
    setInterval(function() {
        $.ajax({
            type: "GET",
            url: "/order/refresh/" + orderid + "/" + update,
            
            success: function(response) {  
                if (response) {
                    document.location.reload();
                }
            }
        });
    }, 10000);
}