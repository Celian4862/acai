document.addEventListener("DOMContentLoaded", function() {
    const element = document.querySelector('nav');
    const elementHeight = element.offsetHeight;
    const newHeight = `calc(100vh - ${elementHeight}px)`;
    const backgroundHalf = document.querySelector('.background-half');
    backgroundHalf.style.height = newHeight;
});