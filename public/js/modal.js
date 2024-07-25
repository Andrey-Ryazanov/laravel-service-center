let entry = document.getElementById('entry');
let personal = document.getElementById('personal');

let toentry = document.querySelector("#toentry")
toentry.addEventListener('click', () => {
    personal.style.display = 'none';
    entry.style.display = 'block';
}) 

let topersonal = document.querySelector("#topersonal")
topersonal.addEventListener('click', () => {
    entry.style.display = 'none';
    personal.style.display = 'block';
}) 