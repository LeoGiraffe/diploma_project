let profile = document.querySelector('.header .flex .profile');
let searchForm = document.querySelector('.header .flex .search-form');
let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
}


document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
}

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
}


/*------------testimonial---------------*/


let slides = document.querySelectorAll('.testimonial-container .testimonial-item');
let index = 0;


function nextSlide() {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}

function prevSlide() {
    slides[index].classList.remove('active');
    index = (index - 1 + slides.length) % slides.length;
    slides[index].classList.add('active');
}


/*-------------counter---------------*/

(() => {
    const counter = document.querySelectorAll('.counter');
    const array = Array.from(counter);

    array.map((item) => {

        let counterInnerText = item.textContent;
        item.textContent = 0;
        let count = 1;
        let speed = item.dataset.speed / counterInnerText;
        function counterUp() {
            item.textContent = count++;
            if (counterInnerText < count) {
                clearInterval(stop);
            }
        }
        const stop = setInterval(() => {
            counterUp();
        }, speed)
    })
})()





/*-------------teacher tab---------------*/
const tabsContainer = document.querySelector(".teacher-tabs");
const aboutSection = document.querySelector(".teacher-section");

tabsContainer.addEventListener('click', (e) => {
    if (e.target.classList.contains('tab-item') && !e.target.classList.contains('active')) {
        const currentActive = tabsContainer.querySelector('.tab-item.active');
        if (currentActive) {
            currentActive.classList.remove('active');
        }
        
        e.target.classList.add('active');
        const targetId = e.target.getAttribute('data-target');
        
        const currentContent = aboutSection.querySelector('.tab-content.active');
        if (currentContent) {
            currentContent.classList.remove('active');
        }
        const newContent = aboutSection.querySelector(`#${targetId}`);
        if (newContent) {
            newContent.classList.add('active');
        }
    }
});




