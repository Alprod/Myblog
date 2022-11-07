console.log('je suis global')
//Changer en dark mode
// Icon
const sunIcon = document.getElementById('sun');
const moonIcon = document.getElementById('moon');

// Theme Vars
const userTheme = localStorage.getItem('theme');
const systemTheme = window.matchMedia('(prefers-color-sheme: dark').matches;

// Icon Toggle
const iconToggle = () => {
    moonIcon.classList.toggle('hidden');
    sunIcon.classList.toggle('hidden');
};

// Initial theme check
const themeCheck = () => {
    if (userTheme === 'dark' || ( !userTheme && systemTheme )){
        document.documentElement.classList.add('dark')
        moonIcon.classList.add('hidden')
        return;
    }
    sunIcon.classList.add('hidden');
}

// Manual theme switch
const themeSwitch = () => {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark')
        localStorage.setItem('theme', 'light')
        iconToggle();
        return;
    }
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
    iconToggle();
}

// Call theme switch on click buttons
sunIcon.addEventListener('click',() => {
    themeSwitch()
});
moonIcon.addEventListener('click', () => {
    themeSwitch();
});

// Invoke theme check on initial load
themeCheck();