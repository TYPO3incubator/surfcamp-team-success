/* import stylesheets - keep vendor in a seperate file to improve compiling performance*/
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import '../../scss/components/_slider.scss'

import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

window.addEventListener('load', () => {
    new Swiper('.swiper', {
        modules: [Navigation, Pagination],
        loop: true,
        slidesPerView: 'auto',

         // Pagination
         pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<button class="' + className + '" title="Go to slide ' + (index + 1) + '"></button>';
            },
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});