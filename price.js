/* --- Exibindo informações detalhadas --- */

document.getElementById("details-header").onclick = () => {
    if(document.getElementById("details-list").style.display == 'none') {
        document.getElementById("details-list").style.display = 'block';
        document.getElementById("details-header").innerHTML = "<span>&#8681;</span>Informações detalhadas"
    } else {
        document.getElementById("details-list").style.display = 'none';
        document.getElementById("details-header").innerHTML = "<span>&#8688;</span>Informações detalhadas"
    }
};

