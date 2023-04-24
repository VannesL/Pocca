var orderStatus = document.getElementById("orderStatus");

if (orderStatus.textContent.includes("Processing") || orderStatus.textContent.includes("Ready")) {
  setTimeout(() => {
    document.location.reload();
  }, 30000);
}
