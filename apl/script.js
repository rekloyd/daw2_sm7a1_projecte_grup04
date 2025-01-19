console.log("hey");

function toggleContenido(btn, id) {

    const formulario = document.querySelector(".formulario-" + id);

    document.getElementById("mensajeEnter").style.display = "none";
    
    // Comprobamos si el formulario está oculto o no, y alternamos entre mostrar u ocultar
    if (formulario.classList.contains("oculto")) {
        formulario.classList.remove("oculto");
        formulario.classList.add("mostrando");

    } else {
        formulario.classList.remove("mostrando");
        formulario.classList.add("oculto");
        document.getElementById("mensajeEnter").style.display = "block";

    }
}
