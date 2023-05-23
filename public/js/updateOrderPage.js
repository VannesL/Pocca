$(document).ready(function () {
    updateOrders();
})

function updateOrders() {
    setInterval(function() {
        for (let i=0; i<totalOrders; i++) {          
            $.ajax({
                type: "GET",
                url: "/order/" + guard + "/" + orderArr[i] + "/" + updateArr[i] + "/" + totalOrders,
                
                success: function(response) {  
                    if (response) {
                        if (!($('#infoModal').is(':visible'))) {
                            document.location.reload();
                        }     
                    }
                }
            });
        }
    }, 10000);
}