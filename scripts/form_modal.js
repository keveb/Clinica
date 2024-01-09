(function() {
const table = document.getElementById("table");
const modal = document.getElementById("modal");
const inputs = document.querySelectorAll("input");
let count = 0;
window.addEventListener("click", (e) => {
    if (e.target.matches(".btn-warning")) {
    let data = e.target.parentElement.parentElement.children;
    fillData(data);
    modal.classList.toggle("translate");
    }

    if (e.target.matches(".cerrar")) {
    modal.classList.toggle("translate");
    count=0
    }
});

const fillData = (data) => {
for (let index of inputs) {
    if (index.form.id === "form") { // Verificar el ID del formulario
    index.value = data[count].textContent;
    console.log(index);
    count += 1;
    }
}
};
})();