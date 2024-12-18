let slideIndex = 0;  // Índice del slide actual

// Función para mostrar un slide específico según el índice
function showSlide(index) {
    const slides = document.querySelectorAll('.slide');  // Obtener todos los slides
    const slideContainer = document.querySelector('.slide-container');

    // Verificar que el índice no se salga del rango
    if (index >= slides.length) {
        slideIndex = 0;  // Si el índice es mayor al número de slides, volver al primer slide
    } else if (index < 0) {
        slideIndex = slides.length - 1;  // Si el índice es menor que 0, ir al último slide
    } else {
        slideIndex = index;  // De lo contrario, actualizar el índice
    }

    // Calcular el desplazamiento del contenedor de slides
    const offset = -slideIndex * 100;  // Desplazar el contenedor de los slides (100% por slide)
    slideContainer.style.transform = `translateX(${offset}%)`;  // Mover el contenedor de slides
}

// Función para mover al siguiente o anterior slide
function moveSlide(step) {
    showSlide(slideIndex + step);  // Mover al siguiente o anterior slide
}

// Función para mostrar el modal con la imagen o video en grande
function showModal(src, alt) {
    const modal = document.getElementById('myModal');
    const modalImg = document.getElementById('img01');
    const captionText = document.getElementById('caption');

    modal.style.display = "block";  // Mostrar el modal

    // Si es un video, mostrarlo; si es una imagen, mostrarla
    if (src.includes('video')) {
        modalImg.style.display = "none";  // Ocultar imagen
        const video = document.createElement('video');
        video.controls = true;
        video.src = src;
        video.style.maxWidth = "100%";
        modal.appendChild(video);  // Mostrar el video en el modal
    } else {
        modalImg.style.display = "block";  // Mostrar la imagen
        modalImg.src = src;  // Establecer la imagen en el modal
    }

    captionText.innerHTML = alt;  // Establecer el texto alternativo de la imagen o video

    const span = document.getElementsByClassName('close')[0];
    span.onclick = function() {
        modal.style.display = "none";  // Ocultar el modal al hacer clic en el botón de cerrar
        modal.innerHTML = '';  // Limpiar el contenido del modal (video o imagen)
    };

    // Cerrar el modal si el usuario hace clic fuera de la imagen o video
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";  // Ocultar el modal
            modal.innerHTML = '';  // Limpiar el contenido del modal
        }
    };
}

// Mostrar el primer slide al cargar la página
window.onload = function() {
    showSlide(slideIndex);  // Inicializa el primer slide al cargar

    // Función para manejar el clic de "Siguiente"
    document.querySelector('#next').addEventListener('click', function() {
        moveSlide(1);  // Mover al siguiente slide
    });

    // Función para manejar el clic de "Anterior"
    document.querySelector('#prev').addEventListener('click', function() {
        moveSlide(-1);  // Mover al anterior slide
    });
};
// Obtener el checkbox y los elementos de las listas de navegación
const menuToggle = document.getElementById('checkbox');
const leftLinks = document.querySelector('.left-links');
const rightLinks = document.querySelector('.right-links');

// Función que alterna la visibilidad del menú
menuToggle.addEventListener('change', () => {
    if (menuToggle.checked) {
        // Mostrar el menú al marcar el checkbox
        leftLinks.style.display = 'flex';
        rightLinks.style.display = 'flex';
    } else {
        // Ocultar el menú al desmarcar el checkbox
        leftLinks.style.display = 'none';
        rightLinks.style.display = 'none';
    }
});


