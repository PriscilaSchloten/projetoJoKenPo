
window.addEventListener('scroll', function() {
    const scrolled = window.scrollY;
    document.querySelector('.layer-fundo').style.transform = `translateY(${scrolled * 0.2}px)`;
    document.querySelector('.layer-meio').style.transform  = `translateY(${scrolled * 0.4}px)`;
    document.querySelector('.layer-frente').style.transform= `translateY(${scrolled * 0.6}px)`;
});
