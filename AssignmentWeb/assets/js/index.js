const multipleItemsCarousel = document.querySelector('#carouselExample');


if(window.matchMedia('(min-width: 568px)').matches) {
    const carousel = new bootstrap.Carousel(multipleItemsCarousel, {
        interval: false
    });
    let carouselInner = document.querySelector('.carousel-inner');
    if (carouselInner) {
        let carouseWidth = carouselInner.scrollWidth;
        let cardElement = document.querySelector('.carousel-item');
        if (cardElement) {
            let cardWidth = cardElement.offsetWidth;

            let scrollPosition = 0;

            document.querySelector('.carousel-control-next').addEventListener('click', () => {
                if (scrollPosition < (carouseWidth - (cardWidth * 4))) {
                    scrollPosition += cardWidth;
                    carouselInner.scrollTo({ left: scrollPosition, behavior: 'smooth' });
                }
            });

            document.querySelector('.carousel-control-prev').addEventListener('click', () => {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth;
                    carouselInner.scrollTo({ left: scrollPosition, behavior: 'smooth' });
                }
            });
        } else {
            console.error('Element with class "carousel-item" not found.');
        }
    } else {
        console.error('Element with class "carousel-inner" not found.');
    }
}

else {
    multipleItemsCarousel.classList.add('slide');
}