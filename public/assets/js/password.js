document.addEventListener("DOMContentLoaded", () => {
    const password = document.getElementById("password");
    const botonMostrar = document.getElementById("mostrarPassword");
    const icono = botonMostrar.querySelector("i");
    botonMostrar.addEventListener("click", function () {
        if (password.type === "password") {
            password.type = "text";
            icono.classList.remove("bi-eye");
            icono.classList.add("bi-eye-slash");
        } else {
            password.type = "password";
            icono.classList.remove("bi-eye-slash");
            icono.classList.add("bi-eye");
        }
    });
});