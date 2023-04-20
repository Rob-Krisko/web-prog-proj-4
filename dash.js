function manageUsers() {
    console.log("Manage Users");
  }
  
  function manageProperties() {
    console.log("Manage Properties");
  }
  
  function viewReports() {
    console.log("View Reports");
  }
  
  async function fetchPropertyDetails(propertyId) {
    const response = await fetch("property_details.php?id=" + propertyId);
    const data = await response.json();
    return data;
  }
  
  document.addEventListener("DOMContentLoaded", function () {
    const propertyCards = document.querySelectorAll(".property-card:not(.add-property)");
    const propertyModal = document.getElementById("property-modal");
    const closeModal = document.querySelector("#property-modal .close");
  
    propertyCards.forEach((card) => {
      const propertyId = card.dataset.propertyId;
  
      card.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-property-btn")) {
          return;
        }
  
        fetch(`property_details.php?id=${propertyId}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById("modal-address").textContent = data.address;
            document.getElementById("modal-price").textContent = '$' + Number(data.price).toLocaleString();
            document.getElementById("modal-bedrooms").textContent = data.bedrooms + ' bedrooms';
            document.getElementById("modal-bathrooms").textContent = data.bathrooms + ' bathrooms';
            document.getElementById("modal-type").textContent = data.property_type;
            document.getElementById("modal-area").textContent = data.sqft + ' sq ft';
            document.getElementById("modal-year_built").textContent = 'Built in ' + data.year_built;
            document.getElementById("modal-description").textContent = data.description;
            propertyModal.style.display = "block";
          });
      });
  
      const deleteButton = card.querySelector(".delete-property-btn");
      deleteButton.addEventListener("click", function (event) {
        event.stopPropagation();
        
        fetch("delete_property.php", {
          method: "POST",
          body: new URLSearchParams(Object.entries({ propertyId })),
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === "success") {
              card.remove();
            } else {
              console.error("Error removing property");
            }
          });
      });
    });
  
    closeModal.addEventListener("click", function () {
      propertyModal.style.display = "none";
    });
  
    window.addEventListener("click", function (event) {
      if (event.target === propertyModal) {
        propertyModal.style.display = "none";
      }
    });
  });
  