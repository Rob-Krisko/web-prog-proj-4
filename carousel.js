let currentIndex = 0;
const carouselItems = document.querySelectorAll('.carousel-item');

function showSlide(index) {
  carouselItems.forEach((item, i) => {
    if (i === index) {
      item.classList.add('active');
    } else {
      item.classList.remove('active');
    }
  });
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % carouselItems.length;
  showSlide(currentIndex);
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
  showSlide(currentIndex);
}

// Initialize the carousel by showing the first slide
showSlide(currentIndex);

// Auto transition between slides
setInterval(nextSlide, 5000); // Change the value (in milliseconds) to adjust the transition interval
