var orderStatus = document.getElementById("orderStatus");

if (orderStatus && (orderStatus.textContent.includes("In Payment") || orderStatus.textContent.includes("Ready"))) {
  setTimeout(() => {
    document.location.reload();
  }, 30000);
}

var customerOrderStatus = document.getElementById("customerOrderStatus");
var payed = document.getElementById("payed");

if (customerOrderStatus && (customerOrderStatus.textContent.includes("Processing") || customerOrderStatus.textContent.includes("Cooking") || payed)) {
  setTimeout(() => {
    document.location.reload();
  }, 30000);
}
