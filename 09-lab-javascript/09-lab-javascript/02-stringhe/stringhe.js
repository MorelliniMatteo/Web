const risultato = document.querySelector("div");

//document.querySelectorAll("input")[0].addEventListener("click", function(){
document.querySelector("input[value='Testo uppercase']").addEventListener("click", function(){
    let testo = risultato.innerHTML;
    testo = testo.toUpperCase();
    risultato.innerHTML = testo;
})

//document.querySelectorAll("input")[1].addEventListener("click", function() {
document.querySelector("input[value='Testo lowercase']").addEventListener("click", function() { 
    let testo = risultato.innerHTML;
    testo = testo.toLowerCase();
    risultato.innerHTML = testo;
})

//document.querySelectorAll("input")[2].addEventListener("click", function() {
document.querySelector("input:last-of-type").addEventListener("click", function() {
    let testo = risultato.innerHTML;
    //let testo_spostato = testo.substring(5, testo.length) + testo.substring(0, 5);
    let testo_spostato = testo.slice(5, testo.length) + testo.slice(0,5);

    risultato.innerHTML = testo_spostato;
})