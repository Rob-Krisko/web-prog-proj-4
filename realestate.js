// Registration form handling
const step1 = document.getElementById("step1");
const step2 = document.getElementById("step2");
const step3 = document.getElementById("step3");

const next1 = document.getElementById("next1");
const noPayment = document.getElementById("noPayment");
const yesPayment = document.getElementById("yesPayment");
const submitRegistration = document.getElementById("submitRegistration");

// Function to show step 2
function showStep2() {
  step1.style.display = "none";
  step2.style.display = "block";
}

// Function to show step 3
function showStep3() {
  step2.style.display = "none";
  step3.style.display = "block";
}

// Function to submit the registration form
function submitForm() {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "register.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      if (this.responseText === "success") {
        // Redirect to the login modal upon successful registration
        document.getElementById("register-modal").style.display = "none";
        document.getElementById("login-modal").style.display = "block";
      } else {
        // Display an error message if the registration failed
        console.error(this.responseText);
      }
    }
  };

  const formData = new FormData(document.getElementById("register-form"));
  const encodedData = new URLSearchParams(formData).toString();
  xhr.send(encodedData);
}

document.addEventListener("DOMContentLoaded", function () {
  if (next1) {
    next1.addEventListener("click", function (event) {
      event.preventDefault();
      showStep2();
    });
  }

  if (noPayment) {
    noPayment.addEventListener("click", function (event) {
      event.preventDefault();
      submitForm();
    });
  }

  if (yesPayment) {
    yesPayment.addEventListener("click", function (event) {
      event.preventDefault();
      showStep3();
    });
  }

  if (submitRegistration) {
    submitRegistration.addEventListener("click", function (event) {
      event.preventDefault();
      submitForm();
    });
  }

  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const password = document.getElementById("password-register").value;
      const confirmPassword = document.getElementById("confirm-password").value;

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
      } else {
        const registerForm = document.getElementById("register-form");
        if (registerForm) {
          registerForm.addEventListener("submit", function (event) {
            event.preventDefault();
        
            const password = document.getElementById("password-register").value;
            const confirmPassword = document.getElementById("confirm-password").value;
        
            if (password !== confirmPassword) {
              alert("Passwords do not match.");
            } else {
              submitForm();
            }
          });
        }
        
      }
    });
  }

  const loginModalBtn = document.getElementById("login-modal-btn");
  if (loginModalBtn) {
    loginModalBtn.addEventListener("click", function () {
      const loginModal = document.getElementById("login-modal");
      if (loginModal) {
        loginModal.style.display = "block";
      }
    });
  }

  var registerModalBtn = document.getElementById("register-modal-btn");
  if (registerModalBtn) {
    registerModalBtn.addEventListener("click", function () {
      document.getElementById("register-modal").style.display = "block";
    });
  }

  document.querySelectorAll(".login-link").forEach(function (element) {
    element.addEventListener("click", function () {
      document.getElementById("login-modal").style.display = "block";
    });
  });
  

  var modals = document.getElementsByClassName("modal");
  var closeModalButtons = document.getElementsByClassName("close-modal");

  for (var i = 0; i < closeModalButtons.length; i++) {
    closeModalButtons[i].addEventListener("click", function () {
      for (var j = 0; j < modals.length; j++) {
        modals[j].style.display = "none";
      }
    });
  }

  window.addEventListener("click", function (event) {
    for (var i = 0; i < modals.length; i++) {
      if (event.target == modals[i]) {
        modals[i].style.display = "none";
      }
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      for (var i = 0; i < modals.length; i++) {
        modals[i].style.display = "none";
      }
    }
  });
});


// carousel scripts
document.addEventListener("DOMContentLoaded", function () {
  let currentIndex = 0;
  const carouselItems = document.querySelectorAll('.carousel-item');
  const prevButton = document.querySelector('.carousel-control.prev');
  const nextButton = document.querySelector('.carousel-control.next');

  function showSlide(index) {
    carouselItems.forEach((item, i) => {
      if (i === index) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % carouselItems.length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
    showSlide(currentIndex);
  }

  // Initialize the carousel by showing the first slide
  showSlide(currentIndex);

  // Auto transition between slides
  setInterval(nextSlide, 5000); // Change the value (in milliseconds) to adjust the transition interval

  // Add event listeners for the carousel buttons
  if (prevButton) {
    prevButton.addEventListener('click', prevSlide);
  }

  if (nextButton) {
    nextButton.addEventListener('click', nextSlide);
  }
});

