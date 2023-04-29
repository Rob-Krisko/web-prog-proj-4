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
  

  const displayProperties = (properties) => {
    const propertiesContainer = document.getElementById("propertiesContainer");
    propertiesContainer.innerHTML = "";
  
    console.log("Displaying properties:", properties); // Add this line
  
    if (properties && properties.length > 0) {
      properties.forEach((property) => {
        const propertyCard = createPropertyCard(property);
        propertiesContainer.appendChild(propertyCard);
      });
    } else {
      propertiesContainer.innerHTML = "<p>No properties found matching your criteria.</p>";
    }
  };
  


  const createPropertyCard = (property) => {
    const propertyCard = document.createElement("div");
    propertyCard.classList.add("property-card");

    console.log("Image URL:", property.image);
  
    const propertyImage = property.image ? property.image : "default.jpg";
  
    propertyCard.innerHTML = `
      <div class="property-card-image">
        <img src="${propertyImage}" alt="${property.address}">
      </div>
      <div class="property-card-text">
        <h3>${property.address}</h3>
        <p>${property.property_type} - ${property.bedrooms} Beds - ${property.bathrooms} Baths</p>
        <p>$${property.price.toLocaleString()}</p>
      </div>
    `;
    propertyCard.addEventListener("click", () => showModal(property));
    return propertyCard;
  };
  
  

  const showModal = (property) => {
    const modal = document.getElementById("propertyModal");
    document.getElementById("modalImage").src = property.image;
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
    const searchInput = document.getElementById("searchInput").value;
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
      searchInput,
      homeType,
      minPrice,
      maxPrice,
      bedrooms,
      bathrooms,
      currentPage,
      itemsPerPage
    );
    totalPages = Math.ceil(data.totalItems / itemsPerPage);
  
    displayProperties(data.properties);
    createPaginationButtons(totalPages);
    attachPaginationListeners();
  };
  
  document.getElementById("updateFilters").addEventListener("click", () => {
    currentPage = 1;
    updateProperties();
  });

  document.getElementById("resetFilters").addEventListener("click", () => {
    document.getElementById("searchInput").value = "";
    document.querySelector('input[name="propertyType"][value="Any"]').checked = true;
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    Array.from(document.querySelectorAll('input[name="bedrooms"]')).forEach((checkbox) => (checkbox.checked = false));
    Array.from(document.querySelectorAll('input[name="bathrooms"]')).forEach((checkbox) => (checkbox.checked = false));

    currentPage = 1;
    updateProperties();
  });

  let totalPages = 1;
  updateProperties();
});
