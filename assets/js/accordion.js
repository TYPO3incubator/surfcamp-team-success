initAccodion()

function initAccodion() {
    let accordions = document.querySelectorAll(".accordion-button-js");

    Array.prototype.forEach.call(accordions, function(accordion) {
        accordion.addEventListener('click', ( e ) => {
            e.preventDefault();
            let target = document.getElementById(accordion.getAttribute('data-accordion-toggle'));

            if (target) {
                let plus = accordion.closest('.accordion-plus-js');
                let minus = accordion.closest('.accordion-minus-js');

                if (plus) {
                    plus.classList.toggle('hidden');
                }

                if (minus) {
                    minus.classList.toggle('hidden');
                }

                slideToggle(target);
            }
        });
    });
}

let globalTimeout; 

function slideUp (element, duration = 500) {
    return new Promise(function (resolve, reject) {
        element.style.height = element.offsetHeight + 'px';
        element.style.transitionProperty = `height, margin, padding`;
        element.style.transitionDuration = duration + 'ms';
        element.offsetHeight;
        element.style.overflow = 'hidden';
        element.style.height = '0';
        element.style.paddingTop = '0';
        element.style.paddingBottom = '0';
        element.style.marginTop = '0';
        element.style.marginBottom = '0';
        globalTimeout = setTimeout(() => {
            element.style.display = 'none';
            element.style.removeProperty('height');
            element.style.removeProperty('padding-top');
            element.style.removeProperty('padding-bottom');
            element.style.removeProperty('margin-top');
            element.style.removeProperty('margin-bottom');
            element.style.removeProperty('overflow');
            element.style.removeProperty('transition-duration');
            element.style.removeProperty('transition-property');
            resolve(false);
        }, duration)
    })
}

function slideDown (element, duration = 300) {
    let display = window.getComputedStyle(element).display;
    element.style.removeProperty('display');
    
    if (display === 'none')
        display = 'block';

    element.style.display = display;
    let height = element.offsetHeight;
    element.style.overflow = 'hidden';
    element.style.height = '0';
    element.style.paddingTop = '0';
    element.style.paddingBottom = '0';
    element.style.marginTop = '0';
    element.style.marginBottom = '0';
    element.offsetHeight;
    element.style.transitionProperty = `height, margin, padding`;
    element.style.transitionDuration = duration + 'ms';
    element.style.height = height + 'px';
    element.style.removeProperty('padding-top');
    element.style.removeProperty('padding-bottom');
    element.style.removeProperty('margin-top');
    element.style.removeProperty('margin-bottom');
    globalTimeout = setTimeout(() => {
        element.style.removeProperty('height');
        element.style.removeProperty('overflow');
        element.style.removeProperty('transition-duration');
        element.style.removeProperty('transition-property');
    }, duration)
}

function slideToggle (target, duration = 300) {
    if (window.getComputedStyle(target).display === 'none') {
        return slideDown(target, duration);
    } else {
        return slideUp(target, duration);
    }
}