import Swiper from "swiper/bundle";

document.addEventListener("DOMContentLoaded", function () {
    let swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 50,
        centeredSlides: false,
        freeMode: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: true,
        },
        allowTouchMove: true, // Habilita el desplazamiento con el mouse o el dedo.
        loop: true,
        breakpoints: {
            480: {
                slidesPerView: 2,
                spaceBetween: 20,
                centeredSlides: false,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
                centeredSlides: false,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 20,
                centeredSlides: false,
            },
        },
    });

    let swiperPopular = new Swiper(".swiper-popular", {
        slidesPerView: 1,
        spaceBetween: 50,
        centeredSlides: false,
        freeMode: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        allowTouchMove: true, // Habilita el desplazamiento con el mouse o el dedo.
        loop: true,
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
                centeredSlides: false,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
                centeredSlides: false,
            },
        },
    });

    /*     let swiperCoustomers = new Swiper(".swiper-Coustomers", {
        slidesPerView: 2,
        spaceBetween: 50,
        freeMode: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        allowTouchMove: true, // Habilita el desplazamiento con el mouse o el dedo.
        loop: true,
        breakpoints: {
            768: {
                slidesPerView: 6,
                spaceBetween: 20,
                centeredSlides: false,
            },
        },
    }); */
});
