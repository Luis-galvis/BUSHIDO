document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.mySwiper', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 3, // Muestra 3 tarjetas a la vez
        loop: true,
        coverflowEffect: {
            rotate: 40,
            stretch: 0,
            depth: 400,
            modifier: 1,
            slideShadows: false,
        },
        speed: 600,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});





