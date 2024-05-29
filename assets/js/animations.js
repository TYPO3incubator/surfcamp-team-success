import { animateCountUp } from './counter-animation'

const numbersCe = document.querySelector('[data-el="numbers"]');

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
          observer.disconnect()
          if (numbers.length) {
            numbers.forEach((number) => {
              animateCountUp(number, 2500)
            })
          }
        }
    })
}, { threshold: 0.2 });

if (numbersCe) {
  const numbers = numbersCe.querySelectorAll('[data-el="number"]')
  observer.observe(numbersCe)
}
