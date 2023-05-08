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
                    if (!($('#infoModal').is(':visible'))) {
                        document.location.reload();
                    }
                }
            }
        });
    }, 10000);
}