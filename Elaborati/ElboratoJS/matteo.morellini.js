document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll('.slider-image img');
    const totalImages = images.length;

    for (let i = 2; i < totalImages; i++) {
        images[i].style.display = 'none';
    }

    images[0].classList.add('current');
    images[1].style.display = 'inline-block';

    images.forEach(function(image, index) {
        image.addEventListener('click', function() {
            if (!this.classList.contains('current')) {
                const currentIndex = Array.from(images).indexOf(this);

                images.forEach(function(img) {
                    img.classList.remove('current');
                    img.style.display = 'none';
                });

                this.classList.add('current');
                this.style.display = 'inline-block';

                if (currentIndex === 0) {
                    images[1].style.display = 'inline-block';
                } else if (currentIndex === totalImages - 1) {
                    images[currentIndex - 1].style.display = 'inline-block';
                } else {
                    images[currentIndex - 1].style.display = 'inline-block';
                    images[currentIndex + 1].style.display = 'inline-block';
                }
            }
        });
    });
});
