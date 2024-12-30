function showSection(sectionId) {
  // Hide all sections
  document.querySelectorAll('section').forEach(section => {
    section.style.display = 'none';
  });

  // Show the selected section
  document.getElementById(sectionId).style.display = 'block';
}

// Show default sections on page load
window.onload = function () {
  ['home', 'about', 'services', 'contact'].forEach(id => {
    document.getElementById(id).style.display = 'block';
  });
};






// Function to navigate between sections
document.querySelectorAll('.nav-links a, .switch-form').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const target = this.getAttribute('href').substring(1);
  
      // Deactivate all sections
      document.querySelectorAll('.content').forEach(section => {
        section.classList.remove('active');
      });
  
      // Activate the target section
      const targetSection = document.getElementById(target);
      if (targetSection) {
        targetSection.classList.add('active');
      }
    });
  });
  
  // Function to show service details dynamically
  function showService(service) {
    const title = document.getElementById('service-title');
    const description = document.getElementById('service-description');
  
    title.innerText = `${service} Details`;
    description.innerText = `Information about ${service}... This is where you can describe what ${service} entails and provide further details.`;
  }
  
  // Load the correct section on page load based on URL hash
  window.addEventListener('load', () => {
    const hash = window.location.hash.substring(1);
  
    // Check if the hash corresponds to a section
    if (hash) {
      const targetSection = document.getElementById(hash);
      if (targetSection) {
        document.querySelectorAll('.content').forEach(section => {
          section.classList.remove('active');
        });
        targetSection.classList.add('active');
      }
    }
  });
  
  // Add a listener for hash changes to handle navigation directly from URL
  window.addEventListener('hashchange', () => {
    const hash = window.location.hash.substring(1);
  
    // Check if the hash corresponds to a section
    if (hash) {
      const targetSection = document.getElementById(hash);
      if (targetSection) {
        document.querySelectorAll('.content').forEach(section => {
          section.classList.remove('active');
        });
        targetSection.classList.add('active');
      }
    }
  });


  document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");
  
    // Toggle menu visibility
    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("show"); // Toggle the "show" class to show/hide the menu
    });
  });
  



  document.addEventListener("DOMContentLoaded", () => {
    const userLogin = document.getElementById("userLogin");
    const adminLogin = document.getElementById("adminLogin");
    const signupSection = document.getElementById("signupSection");
  
    // Switch to User Login
    userLogin.addEventListener("click", () => {
      userLogin.classList.add("active");
      adminLogin.classList.remove("active");
      signupSection.style.display = "block";
    });
  
    // Switch to Admin Login
    adminLogin.addEventListener("click", () => {
      adminLogin.classList.add("active");
      userLogin.classList.remove("active");
      signupSection.style.display = "none";
    });
  
    // Smooth Scroll to Signup
    document.querySelector(".signup-link").addEventListener("click", (e) => {
      e.preventDefault();
      document.getElementById("signup").scrollIntoView({ behavior: "smooth" });
    });
  });
  





  // navbar
// Ensure navbar closes when any nav-link is clicked on mobile
document.querySelectorAll('.navbar-nav .nav-link').forEach(function(link) {
  link.addEventListener('click', function () {
    // Check if the navbar is collapsed (visible on mobile)
    const navbarCollapse = document.getElementById('navbarNav');
    if (navbarCollapse.classList.contains('show')) {
      // Close the navbar
      navbarCollapse.classList.remove('show');
    }
  });
});

// Optional: Bootstrap 5 should already handle toggling correctly, this is a safeguard.
const navbarToggler = document.querySelector('.navbar-toggler');
navbarToggler.addEventListener('click', function () {
  const navbarCollapse = document.getElementById('navbarNav');
  navbarCollapse.classList.toggle('show');
});






document.addEventListener('DOMContentLoaded', function() {
  // Get references to sections and body
  const loginSection = document.getElementById('login');
  const signupSection = document.getElementById('signup');
  const body = document.body;
  
  // Get references to the login and signup links
  const showLoginLink = document.getElementById('showLogin');
  const showSignupLink = document.getElementById('showSignup');

  // Function to show login section and hide signup section
  function showLoginSection() {
    loginSection.classList.remove('hidden');
    signupSection.classList.add('hidden');
    body.style.opacity = '0.5'; // Dim the background
  }

  // Function to show signup section and hide login section
  function showSignupSection() {
    signupSection.classList.remove('hidden');
    loginSection.classList.add('hidden');
    body.style.opacity = '0.5'; // Dim the background
  }

  // Function to hide both sections and restore background opacity
  function hideSections() {
    loginSection.classList.add('hidden');
    signupSection.classList.add('hidden');
    body.style.opacity = '1'; // Reset background opacity
  }

  // Event listeners to show login or signup section when the links are clicked
  showLoginLink.addEventListener('click', function(e) {
    e.preventDefault();
    showLoginSection();
  });

  showSignupLink.addEventListener('click', function(e) {
    e.preventDefault();
    showSignupSection();
  });

  // Event listener to close sections when clicking outside
  window.addEventListener('click', function(e) {
    if (!loginSection.contains(e.target) && !signupSection.contains(e.target)) {
      hideSections();
    }
  });

  // Prevent closing if clicking inside login or signup form
  loginSection.addEventListener('click', function(e) {
    e.stopPropagation();
  });
  signupSection.addEventListener('click', function(e) {
    e.stopPropagation();
  });
});