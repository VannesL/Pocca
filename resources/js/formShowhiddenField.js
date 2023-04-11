const selectElement = document.querySelector("#selectCanteen");
 
    selectElement.addEventListener("change", (event) => {
        const field = document.querySelector("#x");
        if (event.target.value== (-1)) {
            field.style.display ='block';
        }else{
            field.style.display ='none';
        }           // result.textContent = `You like ${event.target.value}`;
});