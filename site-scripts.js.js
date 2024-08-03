console.log("Script loaded");

// Function to initialize the menu state
function initializeMenu() {
    const mainNav = document.getElementById('mainNav');
    if (mainNav) {
        mainNav.classList.add('hidden');
    }
}

// Hamburger menu functionality
const hamburgerMenu = document.querySelector('.hamburger-menu');
const mainNav = document.getElementById('mainNav');

if (hamburgerMenu && mainNav) {
    hamburgerMenu.addEventListener('click', function(event) {
        event.stopPropagation();
        mainNav.classList.toggle('hidden');
        this.classList.toggle('change'); // Toggles the hamburger icon change
    });

    document.addEventListener('click', function(event) {
        if (!mainNav.contains(event.target) && event.target !== hamburgerMenu) {
            mainNav.classList.add('hidden');
            hamburgerMenu.classList.remove('change'); // Reset hamburger icon
        }
    });
}

// Run initialization when DOM content is loaded
document.addEventListener('DOMContentLoaded', initializeMenu);

// Privacy Policy Modal
const modal = document.getElementById("privacy-policy-modal");
const btn = document.getElementById("privacy-policy-link");
const span = document.getElementsByClassName("close")[0];

if (btn) {
    btn.onclick = function(e) {
        e.preventDefault();
        modal.style.display = "block";
    }
}

if (span) {
    span.onclick = function() {
        modal.style.display = "none";
    }
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Form validation
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(event) {
        let isValid = true;
        const inputs = this.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea');

        inputs.forEach(function(input) {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        });

        const privacyAgree = document.getElementById('privacy_agree');
        if (privacyAgree && !privacyAgree.checked) {
            isValid = false;
            alert('Please agree to the Privacy Policy.');
        }

        if (!isValid) {
            event.preventDefault();
            alert('Please fill in all fields and agree to the Privacy Policy.');
        }
    });
}
