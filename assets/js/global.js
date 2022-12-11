console.log('je suis global')
//Changer en dark mode
// Icon
const sunIcon = document.getElementById('sun');
const moonIcon = document.getElementById('moon');
const sunIconBurger = document.getElementById('sunBurger');
const moonIconBurger = document.getElementById('moonBurger');

// Theme Vars
const userTheme = localStorage.getItem('theme');
const systemTheme = window.matchMedia('(prefers-color-sheme: dark').matches;

// Icon Toggle
const iconToggle = (moon, sun) => {
    moon.classList.toggle('hidden');
    sun.classList.toggle('hidden');
};

// Initial theme check
const themeCheck = (moon, sun) => {
    if (userTheme === 'dark' || ( !userTheme && systemTheme )){
        document.documentElement.classList.add('dark')
        moon.classList.add('hidden')
        return;
    }
    sun.classList.add('hidden');
}

// Manual theme switch
const themeSwitch = (moon, sun) => {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark')
        localStorage.setItem('theme', 'light')
        iconToggle(moon, sun);
        return;
    }
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
    iconToggle(moon, sun);
}

// Call theme switch on click buttons
sunIcon.addEventListener('click',() => {
    themeSwitch(moonIcon, sunIcon)
});
moonIcon.addEventListener('click', () => {
    themeSwitch(moonIcon, sunIcon);
});

// Invoke theme check on initial load
themeCheck(moonIcon, sunIcon);

sunIconBurger.addEventListener('click', () => {
    themeSwitch(moonIconBurger, sunIconBurger);
});

moonIconBurger.addEventListener('click', () => {
    themeSwitch(moonIconBurger, sunIconBurger);
});

themeCheck(moonIconBurger, sunIconBurger);

const navbar = document.getElementById('navbar');
const burgerButton = document.getElementById('burger');
burgerButton?.addEventListener('click', () => {
    navbar.classList.toggle('hidden');
})
