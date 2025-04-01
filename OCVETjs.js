// OCVETjs.js

const header = document.querySelector('header');
const nav = document.querySelector('nav');
const navLogo = document.querySelector('.nav-logo');
const navSearch = document.querySelector('.nav-search');
const heroSection = document.querySelector('.hero') || document.querySelector('.about-us-page'); // Fallback to about-us-page
const headerSearchContainer = document.querySelector('.search-container');
const headerHeight = header ? header.offsetHeight : 0;
const heroHeight = heroSection ? heroSection.offsetHeight : window.innerHeight; // Fallback height

function updateNavPosition() {
    if (!header || !nav || !heroSection) return; // Exit if critical elements are missing
    
    const scrollPosition = window.scrollY;
    
    nav.classList.toggle('fixed', scrollPosition > headerHeight);
    heroSection.classList.toggle('fixed-nav', scrollPosition > headerHeight);

    if (scrollPosition > 100) {
        nav.classList.add('scrolled');
        navLogo.style.display = 'flex';
        navLogo.style.opacity = '1';
        
        if (headerSearchContainer && headerSearchContainer.parentElement === header) {
            navSearch.innerHTML = '';
            navSearch.appendChild(headerSearchContainer);
            headerSearchContainer.style.position = 'static';
            headerSearchContainer.style.opacity = '1';
        }
        navSearch.style.display = 'block';
        navSearch.style.opacity = '1';
    } else {
        nav.classList.remove('scrolled');
        navLogo.style.display = 'none';
        navLogo.style.opacity = '0';
        
        if (headerSearchContainer && headerSearchContainer.parentElement === navSearch) {
            header.appendChild(headerSearchContainer);
            headerSearchContainer.style.position = 'absolute';
            headerSearchContainer.style.right = '20px';
            headerSearchContainer.style.top = '35px';
            headerSearchContainer.style.opacity = '1';
        }
        navSearch.style.display = 'none';
        navSearch.style.opacity = '0';
    }

    const triangleHeight = Math.min(50 + (scrollPosition / heroHeight) * 50, 100);
    heroSection.style.setProperty('--triangle-height', `${triangleHeight}vh`);
}

// Run immediately on script load to set initial state
updateNavPosition();

// Also run on full page load (for cached pages or slower resources)
window.addEventListener('load', updateNavPosition);

// Debounced scroll handler to prevent excessive updates
let scrollTimeout;
window.addEventListener('scroll', () => {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(updateNavPosition, 10); // Adjust delay as needed
});

// Search button toggle
const searchIcon = document.querySelector('.icon');
const searchInput = document.querySelector('.search');
if (searchIcon && searchInput) {
    searchIcon.addEventListener('click', () => {
        searchInput.classList.toggle('active');
        if (searchInput.classList.contains('active')) {
            searchInput.focus();
        }
    });
}

function goToAboutUs() {
    window.location.href = 'OCVET-aboutUs.html';
}

// Modal and form validation (only if modal exists)
$(document).ready(function() {
    if ($('#loginModal').length) {
        function switchTab(tabName) {
            var $currentTab = $('.tab-content > div.active');
            var $newTab = $('#' + tabName);
            $('.tab').removeClass('active');
            $(`.tab-group a[href="#${tabName}"]`).parent().addClass('active');

            if ($currentTab.length) {
                var isSignupToLogin = tabName === 'login';
                $currentTab.addClass(isSignupToLogin ? 'slide-out-to-left' : 'slide-out-to-right');
                $currentTab.one('animationend', function() {
                    $currentTab.removeClass('active slide-out-to-left slide-out-to-right');
                });
            }

            $newTab.addClass('active');
            $newTab.addClass(tabName === 'login' ? 'slide-in-from-right' : 'slide-in-from-left');
            $newTab.one('animationend', function() {
                $newTab.removeClass('slide-in-from-right slide-in-from-left');
            });
        }

        function openModal() {
            $('#loginModal').css('display', 'flex');
        }

        function closeModal(event) {
            if (event.target === document.getElementById('loginModal') || event.target.classList.contains('modal-close')) {
                $('#loginModal').css('display', 'none');
            }
        }
        window.onclick = closeModal;

        window.switchTab = switchTab;
        window.openModal = openModal;
        window.closeModal = closeModal;
    }

    window.goToAboutUs = goToAboutUs;
});