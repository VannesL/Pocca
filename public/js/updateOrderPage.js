$(document).ready(function () {
    updateOrders();
})

function updateOrders() {
    setInterval(function() {
        for (let i=0; i<totalOrders; i++) {
            if (guard == "vendor") {
                var url = "/order/vendor/" + orderArr[i] + "/" + updateArr[i] + "/" + totalOrders;
            } else {
                var url = "/order/customer/" + orderArr[i] + "/" + updateArr[i];
            }
            
            $.ajax({
                type: "GET",
                url: url,
                
                success: function(response) {  
                    if (response) {
                        document.location.reload();
                    }
                }
            });
        }
    }, 10000);
}