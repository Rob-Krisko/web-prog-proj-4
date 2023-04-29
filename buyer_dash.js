document.addEventListener("DOMContentLoaded", () => {
  let currentPage = 1;
  const itemsPerPage = 8;

  const fetchProperties = async (
    searchInput = "",
    homeType = "Any",
    minPrice = 0,
    maxPrice = 1000000,
    bedrooms = [],
    bathrooms = [],
    page = 1,
    itemsPerPage = 8
  ) => {
    const url = new URL("./get_properties.php", window.location.href);
    url.search = new URLSearchParams({
      search: searchInput,
      homeType: homeType,
      minPrice: minPrice,
      maxPrice: maxPrice,
      bedrooms: JSON.stringify(bedrooms),
      bathrooms: JSON.stringify(bathrooms),
      currentPage: page,
      itemsPerPage: itemsPerPage,
    });

    try {
      const response = await fetch(url);

      if (response.ok) {
        const data = await response.json();
        return data;
      } else {
        console.error("Error fetching properties: Response not OK");
        const errorText = await response.text();
        console.error("Error details:", errorText);
      }
    } catch (error) {
      console.error("Error fetching properties:", error);
    }
  };


  const displayProperties = (properties, favoriteProperties) => {
    const propertiesContainer = document.getElementById("propertiesContainer");
    propertiesContainer.innerHTML = "";
  
    console.log("Displaying properties:", properties);
  
    if (properties && properties.length > 0) {
      properties.forEach((property) => {
        const isFavorited = favoriteProperties.some(
          (favorite) => favorite.id === property.id
        );
        const propertyCard = createPropertyCard(property, isFavorited);
        propertiesContainer.appendChild(propertyCard);
      });
    } else {
      propertiesContainer.innerHTML = "<p>No properties found matching your criteria.</p>";
    }
  };
  

  const createPropertyCard = (property, isFavorited) => {
    const propertyCard = document.createElement("div");
    propertyCard.classList.add("property-card");
    const imageURL = property.image
      ? `property_images/${property.image}`
      : "property_images/default.jpg";
    const favoriteIconHTML = isFavorited ? "&#9733;" : "&#9734;";
    propertyCard.innerHTML = `
      <img src="${imageURL}" alt="${property.address}">
      <div class="property-card-text">
        <h3>${property.address}</h3>
        <p>${property.property_type} - ${property.bedrooms} Beds - ${property.bathrooms} Baths</p>
        <p>$${property.price.toLocaleString()}</p>
      </div>
      <span class="favorite-icon ${isFavorited ? 'favorited' : ''}" data-property-id="${property.id}">${favoriteIconHTML}</span>
    `;
    propertyCard.addEventListener("click", (e) => {
      if (!e.target.classList.contains("favorite-icon")) {
        showModal(property);
      }
    });
  
    const favoriteIcon = propertyCard.querySelector(".favorite-icon");
    favoriteIcon.addEventListener("click", async () => {
      const isFavorited = favoriteIcon.classList.contains("favorited");
      const newFavoritedState = !isFavorited;
      favoriteIcon.classList.toggle("favorited", newFavoritedState);
      favoriteIcon.innerHTML = newFavoritedState ? "&#9733;" : "&#9734;";
    
      const propertyId = favoriteIcon.dataset.propertyId;
      if (isFavorited) {
        // Remove favorite
        await toggleFavoriteProperty(propertyId, "remove");
      } else {
        // Add favorite
        await toggleFavoriteProperty(propertyId, "add");
      }
    
      // Sync the favorite state between the main page and the modal
      syncFavoriteState(propertyId, newFavoritedState);
    });
    
    return propertyCard;
  };

  const toggleFavoriteProperty = async (propertyId, action) => {
    const formData = new FormData();
    formData.append("property_id", propertyId);
    formData.append("action", action);

    try {
      const response = await fetch("favorite_property.php", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error("Error toggling favorite property");
      }
    } catch (error) {
      console.error(error);
    }
  };

  const syncFavoriteState = (propertyId, isFavorited) => {
    const mainPageIcon = document.querySelector(
      `.property-card .favorite-icon[data-property-id="${propertyId}"]`
    );
    const modalIcon = document.querySelector(
      `#favoritedPropertiesContainer .favorite-icon[data-property-id="${propertyId}"]`
    );
    const iconsToUpdate = [mainPageIcon, modalIcon].filter((icon) => icon);
  
    iconsToUpdate.forEach((icon) => {
      icon.classList.toggle("favorited", isFavorited);
      icon.innerHTML = isFavorited ? "&#9733;" : "&#9734;";
    });
  };
  

  const showModal = (property) => {
    const modal = document.getElementById("propertyModal");

    console.log("Property object:", property);
    console.log("Image path:", property.image);

    document.getElementById("modalImage").src = 'property_images/' + property.image;
    document.getElementById("modalAddress").textContent = property.address;
    document.getElementById("modalDetails").innerHTML = `
      <li>${property.property_type}</li>
      <li>${property.bedrooms} Beds</li>
      <li>${property.bathrooms} Baths</li>
      <li>$${property.price.toLocaleString()}</li>
    `;
    document.getElementById("modalDescription").textContent = property.description;

    modal.style.display = "block";
  };

  const closeModal = () => {
    const modal = document.getElementById("propertyModal");
    modal.style.display = "none";
  };

  document.getElementsByClassName("close")[0].addEventListener("click", closeModal);

  const createPaginationButtons = (totalPages) => {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = `
      <button id="firstPage">First</button>
      <button id="previousPage">Previous</button>
      <span>Page ${currentPage} of ${totalPages}</span>
      <button id="nextPage">Next</button>
      <button id="lastPage">Last</button>
    `;
  };

  const attachPaginationListeners = () => {
    document.getElementById("firstPage").addEventListener("click", () => goToPage(1));
    document.getElementById("previousPage").addEventListener("click", () => goToPage(currentPage - 1));
    document.getElementById("nextPage").addEventListener("click", () => goToPage(currentPage + 1));
    document.getElementById("lastPage").addEventListener("click", () => goToPage(totalPages));
  };

  const goToPage = (pageNumber) => {
    if (pageNumber < 1 || pageNumber > totalPages) {
      return;
    }

    currentPage = pageNumber;
    updateProperties();
  };

  const updateProperties = async () => {
    // Fetch favorite properties for the current user
    const favoriteProperties = await fetchFavoriteProperties();
  
    // Fetch and display the properties with the favorite status
    const homeType = document.querySelector('input[name="propertyType"]:checked')
      .value;
    const minPrice = document.getElementById("minPrice").value || 0;
    const maxPrice = document.getElementById("maxPrice").value || 1000000;
    const bedrooms = Array.from(
      document.querySelectorAll('input[name="bedrooms"]:checked')
    ).map((checkbox) => checkbox.value);
    const bathrooms = Array.from(
      document.querySelectorAll('input[name="bathrooms"]:checked')
    ).map((checkbox) => checkbox.value);
  
    const data = await fetchProperties(
      "",
      homeType,
      minPrice,
      maxPrice,
      bedrooms,
      bathrooms,
      currentPage,
      itemsPerPage
    );
    totalPages = Math.ceil(data.totalItems / itemsPerPage);
  
    displayProperties(data.properties, favoriteProperties);
    createPaginationButtons(totalPages);
    attachPaginationListeners();
  };
  

  document.getElementById("updateFilters").addEventListener("click", () => {
    currentPage = 1;
    updateProperties();
  });

  document.getElementById("resetFilters").addEventListener("click", () => {
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    document.querySelectorAll('input[name="bedrooms"]:checked').forEach((checkbox) => {
      checkbox.checked = false;
    });
    document.querySelectorAll('input[name="bathrooms"]:checked').forEach((checkbox) => {
      checkbox.checked = false;
    });
    document.querySelector('input[name="propertyType"][value="Any"]').checked = true;

    currentPage = 1;
    updateProperties();
  });

  const displayFavoritesModal = async () => {
    const response = await fetch("get_favorite_properties.php");
    const favorites = await response.json();
  
    const modal = document.getElementById("favoritedPropertiesModal");
    const favoritesContainer = modal.querySelector("#favoritedPropertiesContainer");
    favoritesContainer.innerHTML = "";
  
    favorites.forEach((property) => {
      const propertyCard = createPropertyCard(property, true); // Pass 'true' as the second argument to set the initial favorite state
      favoritesContainer.appendChild(propertyCard);
    });
  
    modal.style.display = "block";
  };
  
  

  const closeFavoritesModal = () => {
    const modal = document.getElementById("favoritedPropertiesModal");
    modal.style.display = "none";
  };
  

  document.getElementById("favoritesLink").addEventListener("click", async (e) => {
    e.preventDefault(); // Prevent the default action (navigating to the '#' anchor)
    displayFavoritesModal();
  });
  

  const fetchFavoriteProperties = async () => {
    try {
      const response = await fetch("get_favorite_properties.php");
  
      if (response.ok) {
        const data = await response.json();
        return data;
      } else {
        console.error("Error fetching favorite properties: Response not OK");
        const errorText = await response.text();
        console.error("Error details:", errorText);
      }
    } catch (error) {
      console.error("Error fetching favorite properties:", error);
    }
  };
  
  

  document.getElementById("favoritesModalClose").addEventListener("click", closeFavoritesModal);

  let totalPages = 1;
  updateProperties();

  
});

