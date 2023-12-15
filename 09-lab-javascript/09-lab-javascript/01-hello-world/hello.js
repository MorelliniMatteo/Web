console.log("Hello word");

//id "ciao"
//const tagHello = document.getElementById("ciao");
const tagHello = document.querySelector("#ciao")
tagHello.innerHTML = "Hello world";
//class "anno"
//const tagYear = document.getElementsByClassName("anno")[1];
//const tagYear = document.querySelector(".anno");
const tagYear = document.querySelectorAll(".anno")[1];
tagYear.innerHTML = "2023";