async function fetchPropertyDetails(propertyId) {
    const response = await fetch("property_details.php?id=" + propertyId);
    const data = await response.json();
    return data;
  }
  
  function openAddPropertyModal() {
    document.getElementById("add-property-modal").style.display = "block";
  }
  
  function closeAddPropertyModal() {
    document.getElementById("add-property-modal").style.display = "none";
  }
  
  function openEditPropertyModal() {
    document.getElementById("edit-property-modal").style.display = "block";
  }
  
  function closeEditPropertyModal() {
    document.getElementById("edit-property-modal").style.display = "none";
  }
  
  document.addEventListener("DOMContentLoaded", function () {
    const propertyCards = document.querySelectorAll(".property-card:not(.add-property)");
    const propertyModal = document.getElementById("property-modal");
    const closeModal = document.querySelector("#property-modal .close");
  
    propertyCards.forEach((card) => {
      const propertyId = card.dataset.propertyId;
  
      card.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-property-btn") || event.target.classList.contains("edit-property-btn")) {
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
  
      const editButton = card.querySelector(".edit-property-btn");
      editButton.addEventListener("click", function (event) {
        event.stopPropagation();
  
        fetchPropertyDetails(propertyId)
          .then(data => {
            document.getElementById("edit-property-id").value = data.id;
            document.getElementById("edit-address").value = data.address;
            document.getElementById("edit-price").value = data.price;
            document.getElementById("edit-bedrooms").value = data.bedrooms;
            document.getElementById("edit-bathrooms").value = data.bathrooms;
            document.getElementById("edit-type").value = data.property_type;
            document.getElementById("edit-area").value = data.sqft;
            document.getElementById("edit-year_built").value = data.year_built;
            document.getElementById("edit-description").value = data.description;
            openEditPropertyModal();
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
  
    const addPropertyCard = document.querySelector(".property-card.add-property");
    addPropertyCard.addEventListener("click", function (event) {
      event.preventDefault();
      openAddPropertyModal();
    });
  
    const addPropertyForm = document.getElementById("add-property-form");
    addPropertyForm.addEventListener("submit", function (event) {
      event.preventDefault();
  
      const formData = new FormData(addPropertyForm);
      fetch("add_property.php", {
          method: "POST",
          body: formData
      })
      .then(response => response.json())
      .then(data => {
          if (data.status === "success") {
              // Reload the page to display the new property
              location.reload();
          } else {
              console.error("Error adding property:", data.message);
              alert("Error adding property: " + data.message);
          }
      })
      .catch(error => {
        console.error("Error adding property:", error);
        alert("Error adding property: " + error);
      });
    });
  
    const editPropertyForm = document.getElementById("edit-property-form");
    editPropertyForm.addEventListener("submit", function (event) {
      event.preventDefault();
  
      const formData = new FormData(editPropertyForm);
      fetch("update_property.php", {
        method: "POST",
        body: formData
    })
    
      .then(response => response.json())
      .then(data => {
          if (data.status === "success") {
              // Reload the page to display the updated property
              location.reload();
          } else {
              console.error("Error editing property:", data.message);
              alert("Error editing property: " + data.message);
          }
      })
      .catch(error => {
        console.error("Error editing property:", error);
        alert("Error editing property: " + error);
      });
    });
  });
  
  
