// Smooth Scrolling for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Form validation example for sign-up and login
function validateForm() {
    const username = document.forms["signupForm"]["username"].value;
    const password = document.forms["signupForm"]["password"].value;
    const location = document.forms["signupForm"]["location"].value;
    if (username === "" || password === "" || location === "") {
        alert("All fields must be filled out");
        return false;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }
}

document.getElementById("signupForm")?.addEventListener("submit", function(event){
    if (!validateForm()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

// Toggle visibility of elements
function toggleVisibility(selector) {
    const elements = document.querySelectorAll(selector);
    for (let element of elements) {
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
}

// Event listener for toggling elements, example with a button
document.getElementById("toggleButton")?.addEventListener("click", function() {
    toggleVisibility('.toggleElement');
});

// Dark Mode Toggle
function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle("dark-mode");
}

document.querySelector(".dark-mode-toggle")?.addEventListener("click", toggleDarkMode);

// Dynamic content loading example (could be extended for actual use)
function loadContent(url, elementId) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Error loading the data:', error));
}
