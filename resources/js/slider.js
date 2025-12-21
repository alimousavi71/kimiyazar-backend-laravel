import Swiper from "swiper";
import {
    Navigation,
    Pagination,
    Autoplay,
    Keyboard,
    Mousewheel,
} from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// Initialize Swiper when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    const swiperElement = document.querySelector(".hero-slider");

    if (swiperElement) {
        new Swiper(".hero-slider", {
            // Import modules
            modules: [Navigation, Pagination, Autoplay, Keyboard, Mousewheel],

            // Optional parameters
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 800,
            effect: "slide",

            // Navigation arrows
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            // Pagination
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },

            // Responsive breakpoints
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
            },

            // Keyboard control
            keyboard: {
                enabled: true,
            },

            // Mousewheel control
            mousewheel: {
                invert: false,
            },
        });
    }
});
