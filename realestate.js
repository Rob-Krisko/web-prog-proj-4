document.getElementById("register-form").addEventListener("submit", function (event) {
  event.preventDefault();

  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirm-password").value;

  if (password !== confirmPassword) {
    alert("Passwords do not match.");
  } else {
    this.submit();
  }
});

function detectCardType(cardNumber) {
    const cardType = document.getElementById("card-type");
  
    if (/^4[0-9]{12}(?:[0-9]{3})?$/.test(cardNumber)) {
      cardType.value = "Visa";
    } else if (/^5[1-5][0-9]{14}$/.test(cardNumber)) {
      cardType.value = "MasterCard";
    } else if (/^3[47][0-9]{13}$/.test(cardNumber)) {
      cardType.value = "American Express";
    } else if (/^6(?:011|5[0-9]{2})[0-9]{12}$/.test(cardNumber)) {
      cardType.value = "Discover";
    } else if (/^(?:2131|1800|35\d{3})\d{11}$/.test(cardNumber)) {
      cardType.value = "JCB";
    } else if (/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/.test(cardNumber)) {
      cardType.value = "Diners Club";
    } else {
      cardType.value = "";
    }
  }

  function toggleCreditCardSection() {
    const creditCardSection = document.getElementById("credit-card-section");
    const creditCardCheckbox = document.getElementById("credit-card-input");
  
    if (creditCardCheckbox.checked) {
      creditCardSection.style.display = "block";
    } else {
      creditCardSection.style.display = "none";
    }
  }

  function includeHTML() {
    var z, i, elmnt, file, xhttp;
    z = document.getElementsByTagName('*');
    for (i = 0; i < z.length; i++) {
      elmnt = z[i];
      file = elmnt.getAttribute('data-include-html');
      if (file) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {elmnt.innerHTML = this.responseText;}
            if (this.status == 404) {elmnt.innerHTML = 'Page not found.';}
            elmnt.removeAttribute('data-include-html');
            includeHTML();
          }
        }
        xhttp.open('GET', file, true);
        xhttp.send();
        return;
      }
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    includeHTML();
  });
  