const backToTopButton = document.querySelector('.scroll-to-top');

if (backToTopButton) {
  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      backToTopButton.classList.remove('opacity-0');
    } else {
      backToTopButton.classList.add('opacity-0');
    }
  });
  
  backToTopButton.addEventListener('click', function(){
    window.scrollTo({
      top:      0,
      behavior: 'smooth'
    });
  });
}  

