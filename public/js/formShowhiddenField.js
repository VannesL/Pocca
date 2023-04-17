const selectElement = document.querySelector("#selectCanteen");
    selectElement.addEventListener("change", (event) => {
    const field = document.querySelector("#canteenName");
        if (event.target.value== (-1)) {
            field.parentElement.style.display ='block';
        }else{
            field.parentElement.style.display ='none';
        }
    })