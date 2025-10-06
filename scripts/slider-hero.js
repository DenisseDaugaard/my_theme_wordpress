document.addEventListener("DOMContentLoaded", () => {
  initializeSlider();
});

function initializeSlider() {                       

const slidesContainer = document.getElementById("slides-container");
console.log(slidesContainer);

const slides = document.querySelectorAll(".slide");
const prevButton = document.getElementById("slide-arrow-prev");
const nextButton = document.getElementById("slide-arrow-next");

let currentIndex = 0;
const totalSlides = slides.length;

// Helper function to scroll to a specific slide
function goToSlide(index) {
  const slideWidth = slides[0].clientWidth;

  if (index === 0 && currentIndex === totalSlides - 1) {
    // Temporarily disable smooth scroll to avoid reverse animation
    slidesContainer.style.scrollBehavior = 'auto';
    slidesContainer.scrollLeft = 0;
   /* ----------------Re-enable smooth scroll after a short delay ---------*/
    setTimeout(() => {
      slidesContainer.style.scrollBehavior = 'smooth';
    }, 50);
  } else {
    slidesContainer.scrollLeft = slideWidth * index;
  }

  currentIndex = index;
}


// Next / Prev buttons
nextButton.addEventListener("click", () => {
  let nextIndex = currentIndex + 1;
  if (nextIndex >= totalSlides) nextIndex = 0;
  goToSlide(nextIndex);
});

prevButton.addEventListener("click", () => {
  let prevIndex = currentIndex - 1;
  if (prevIndex < 0) prevIndex = totalSlides - 1;
  goToSlide(prevIndex);
});

// Automatic sliding every 5 seconds
setInterval(() => {
  let nextIndex = currentIndex + 1;
  if (nextIndex >= totalSlides) nextIndex = 0;
  goToSlide(nextIndex);
}, 5000); // 5000ms = 5 seconds
}