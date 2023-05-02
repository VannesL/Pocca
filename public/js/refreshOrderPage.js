document.addEventListener("DOMContentLoaded", function(event) { 
    var position = localStorage.getItem('position');
    if (position) {
        window.scrollTo(0, position);
    }
});

window.onbeforeunload = function(e) {
    localStorage.setItem('position', window.scrollY);
};

setTimeout(() => {
    document.location.reload();
}, 30000);