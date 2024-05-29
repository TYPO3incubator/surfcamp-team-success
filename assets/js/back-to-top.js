const backToTopButton = document.querySelector('.scroll-to-top');

const topButtonObserver = new IntersectionObserver(() => {
  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      backToTopButton.style.display = 'block';
    } else {
      backToTopButton.style.display = 'none';
    }
  });

  backToTopButton.addEventListener('click', function(){
    window.scrollTo({
      top:      0,
      behavior: 'smooth'
    });
  });
});

if (backToTopButton) {
  topButtonObserver.observe(backToTopButton);
}
