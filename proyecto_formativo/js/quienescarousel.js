const profesores = {
    1: {
        nombre: "Sensei Juan Pérez",
        descripcion: "Experto en Karate Shotokan con 20 años de experiencia. Ha entrenado a campeones nacionales.",
        imagen: "../fotos/adultos.png"
    },
    2: {
        nombre: "Sensei María González",
        descripcion: "Especialista en Karate-Do y defensa personal. Enfocada en el desarrollo integral de los estudiantes.",
        imagen: "../fotos/1.png "
    },
    3: {
        nombre: "Sensei Carlos Ramírez",
        descripcion: "Instructor certificado en técnicas avanzadas. Comprometido con el crecimiento técnico y ético de los alumnos.",
        imagen: "../fotos/julieth.jpeg"
    },
};

const profesorItems = document.querySelectorAll(".profesor");
const profesorInfo = document.getElementById("profesor-info");
const profesorImagenGrande = document.getElementById("profesor-imagen-grande");
const profesorNombre = document.getElementById("profesor-nombre");
const profesorDescripcion = document.getElementById("profesor-descripcion");

profesorItems.forEach((item) => {
    item.addEventListener("click", () => {
        const id = item.getAttribute("data-profesor");
        const profesor = profesores[id];

        if (profesor) {
            profesorImagenGrande.src = profesor.imagen;
            profesorNombre.textContent = profesor.nombre;
            profesorDescripcion.textContent = profesor.descripcion;
            profesorInfo.style.display = 'block';
        }
    });
});

