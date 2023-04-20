const propertiesContainer = document.getElementById("propertiesContainer");
const updateFilters = document.getElementById("updateFilters");
const resetFilters = document.getElementById("resetFilters");
const minPrice = document.getElementById("minPrice");
const maxPrice = document.getElementById("maxPrice");
const homeType = document.getElementById("homeType");
const bedroomsCheckboxes = document.querySelectorAll("input[name='bedrooms']");
const bathroomsCheckboxes = document.querySelectorAll("input[name='bathrooms']");

let properties = [];
let filteredProperties = [];

async function fetchProperties() {
  const response = await fetch("get_properties.php");
  const data = await response.json();
  properties = data;
  filteredProperties = [...data];
  displayProperties();
}

function displayProperties() {
  propertiesContainer.innerHTML = "";
  for (const property of filteredProperties) {
    const propertyCard = document.createElement("div");
    propertyCard.classList.add("property-card");

    const propertyCardImage = document.createElement("div");
    propertyCardImage.classList.add("property-card-image");
    const img = document.createElement("img");
    img.src = property.image
      ? `property_images/${property.image}`
      : "property_images/default.jpg";
    propertyCardImage.appendChild(img);

    const propertyCardText = document.createElement("div");
    propertyCardText.classList.add("property-card-text");
    propertyCardText.innerHTML = `
            <h4>${property.address}</h4>
            <p>$${property.price.toLocaleString()}</p>
            <p>${property.bedrooms} Beds, ${property.bathrooms} Baths</p>
        `;

    propertyCard.appendChild(propertyCardImage);
    propertyCard.appendChild(propertyCardText);

    propertiesContainer.appendChild(propertyCard);
  }
}

function resetFilterInputs() {
  minPrice.value = "";
  maxPrice.value = "";
  homeType.value = "Any";
  bedroomsCheckboxes.forEach((checkbox) => {
    checkbox.checked = false;
  });
  bathroomsCheckboxes.forEach((checkbox) => {
    checkbox.checked = false;
  });
}

updateFilters.addEventListener("click", () => {
  const min = Number(minPrice.value) || 0;
  const max = Number(maxPrice.value) || Infinity;
  const selectedHomeType = homeType.value;

  const selectedBedrooms = Array.from(bedroomsCheckboxes)
    .filter((checkbox) => checkbox.checked)
    .map((checkbox) => checkbox.value);

  const selectedBathrooms = Array.from(bathroomsCheckboxes)
    .filter((checkbox) => checkbox.checked)
    .map((checkbox) => checkbox.value);

  filteredProperties = properties.filter((property) => {
    const price = Number(property.price);
    const isPriceValid = price >= min && price <= max;
    const isHomeTypeValid =
      selectedHomeType === "Any" || property.property_type === selectedHomeType;
    const isBedroomsValid =
      selectedBedrooms.length === 0 ||
      selectedBedrooms.includes(String(property.bedrooms)) ||
      (selectedBedrooms.includes("3+") && property.bedrooms >= 3);
    const isBathroomsValid =
      selectedBathrooms.length === 0 ||
      selectedBathrooms.includes(String(property.bathrooms)) ||
      (selectedBathrooms.includes("3+") && property.bathrooms >= 3);

    return (
      isPriceValid && isHomeTypeValid && isBedroomsValid && isBathroomsValid
    );
  });

  displayProperties();
});

resetFilters.addEventListener("click", () => {
  resetFilterInputs();
  filteredProperties = [...properties];
  displayProperties();
});

fetchProperties();
