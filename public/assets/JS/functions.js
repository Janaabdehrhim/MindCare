function showSlide(index) {
  slides.forEach((slide) => slide.classList.remove("active"));
  dots.forEach((dot) => dot.classList.remove("active"));
  slides[index].classList.add("active");
  dots[index].classList.add("active");
  current = index;
}


function autoSlide() {
  current = (current + 1) % slides.length;
  showSlide(current);
}


function resetAuto() {
  clearInterval(interval);
  interval = setInterval(autoSlide, 6000);
}

