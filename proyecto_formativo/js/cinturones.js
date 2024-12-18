// Obtén los elementos del DOM
let nextDom = document.getElementById('next');
let prevDom = document.getElementById('prev');

let carouselDom = document.querySelector('.carousel');
let SliderDom = carouselDom.querySelector('.carousel .list');
let thumbnailBorderDom = document.querySelector('.carousel .thumbnail');
let timeDom = document.querySelector('.carousel .time');

// Mueve el primer elemento del thumbnail al final
let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);

let timeRunning = 3000; // Duración de animación

// Asignar eventos de clic a las flechas
nextDom.onclick = function () {
    showSlider('next');
}

prevDom.onclick = function () {
    showSlider('prev');
}

// Función para cambiar el slider
function showSlider(type) {
    let SliderItemsDom = SliderDom.querySelectorAll('.carousel .list .item');
    let thumbnailItemsDom = document.querySelectorAll('.carousel .thumbnail .item');

    if (type === 'next') {
        SliderDom.appendChild(SliderItemsDom[0]); // Mueve el primer elemento al final
        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]); // Lo mismo para los thumbnails
        carouselDom.classList.add('next');
    } else {
        SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]); // Mueve el último elemento al principio
        thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]); // Lo mismo para los thumbnails
        carouselDom.classList.add('prev');
    }

    // Elimina las clases de animación después de un tiempo
    setTimeout(() => {
        carouselDom.classList.remove('next');
        carouselDom.classList.remove('prev');
    }, timeRunning);
}