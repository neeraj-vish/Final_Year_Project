//Javascript code
let currentIndex = 0;
function changeSlide(n) {
  const slides = document.querySelector('.inner-container');
  const totalSlides = document.querySelectorAll('.slide').length;
  currentIndex += n;
  if (currentIndex < 0) {
    currentIndex = totalSlides - 1;
  } else if (currentIndex >= totalSlides) {
    currentIndex = 0;
  }
  slides.style.transform = `translateX(${-currentIndex * 100}%)`;
}
function autoSlide() {
  changeSlide(1);
  
}
setInterval(autoSlide, 3000);
