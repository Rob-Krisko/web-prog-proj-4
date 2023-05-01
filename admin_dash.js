const propertiesContainer = document.getElementById("propertiesContainer");
const usersContainer = document.getElementById("usersContainer");
const propertiesSection = document.getElementById("propertiesSection");
const usersSection = document.getElementById("usersSection");
const analyticsSection = document.getElementById("analyticsSection");
const viewAnalyticsLink = document.getElementById("viewAnalyticsLink");
const managePropertiesLink = document.getElementById("managePropertiesLink");
const manageUsersLink = document.getElementById("manageUsersLink");
const totalPropertyValueGraph = document.getElementById("totalPropertyValueGraph");
const totalUsersGraph = document.getElementById("totalUsersGraph");
const totalUsers = document.getElementById("totalUsers");
const totalProperties = document.getElementById("totalProperties");
const averagePropertyPrice = document.getElementById("averagePropertyPrice");

// Get the modals
const updatePropertyModal = document.getElementById("updatePropertyModal");
const removeUserModal = document.getElementById("removeUserModal");

// Get the close buttons
const updatePropertyCloseBtn = document.querySelector("#updatePropertyModal .close");
const removeUserCloseBtn = document.querySelector("#removeUserModal .close");

// Get the forms
const updatePropertyForm = document.getElementById("updatePropertyForm");
const removeUserForm = document.getElementById("removeUserForm");

// Open modals when "Edit" or "Delete" buttons are clicked
document.addEventListener("click", (event) => {
  if (event.target.classList.contains("edit-property-btn")) {
    // Open the update property modal
    updatePropertyModal.style.display = "block";
  } else if (event.target.classList.contains("delete-user-btn")) {
    // Open the remove user modal
    removeUserModal.style.display = "block";
  }
});

// Close modals when close buttons are clicked
updatePropertyCloseBtn.addEventListener("click", () => {
  updatePropertyModal.style.display = "none";
});

removeUserCloseBtn.addEventListener("click", () => {
  removeUserModal.style.display = "none";
});

// Close modals when clicking outside the modal content
window.addEventListener("click", (event) => {
  if (event.target == updatePropertyModal) {
    updatePropertyModal.style.display = "none";
  } else if (event.target == removeUserModal) {
    removeUserModal.style.display = "none";
  }
});

// Handle form submissions
updatePropertyForm.addEventListener("submit", (event) => {
  event.preventDefault();
  // Handle updating property details here
});

removeUserForm.addEventListener("submit", (event) => {
  event.preventDefault();
  // Handle removing user here
});




function createPropertyCard(property) {
    const propertyCard = document.createElement("div");
    propertyCard.classList.add("property-card");
    propertyCard.id = "property-" + property.id;
    propertyCard.innerHTML = `
        <div class="card-header">
            <h3>${property.address}</h3>
            <button class="expand-btn">Expand</button>
            <button class="delete-property-btn">Delete</button>
        </div>
        <div class="card-content" style="display: none;">
            <p>Price: $${property.price}</p>
            <p>Bedrooms: ${property.bedrooms}</p>
            <p>Bathrooms: ${property.bathrooms}</p>
            <p>Property Type: ${property.property_type}</p>
            <p>Year Built: ${property.year_built}</p>
            <p>Square Feet: ${property.sqft}</p>
            <p>Lot Size: ${property.lot_size}</p>
            <p>Description: ${property.description}</p>
        </div>
    `;

    const expandBtn = propertyCard.querySelector(".expand-btn");
    expandBtn.addEventListener("click", () => {
        const cardContent = propertyCard.querySelector(".card-content");
        cardContent.style.display = cardContent.style.display === "none" ? "block" : "none";
    });

    const deletePropertyBtn = propertyCard.querySelector(".delete-property-btn");
    deletePropertyBtn.addEventListener("click", () => {
        deleteProperty(property.id);
    });

    return propertyCard;
}


function createUserCard(user) {
    const userCard = document.createElement("div");
    userCard.classList.add("user-card");
    userCard.id = "user-" + user.id;

    const userType = user.is_admin == 1 ? 'Admin' : (user.is_seller == 1 ? 'Seller' : 'Buyer');

    userCard.innerHTML = `
        <h3>${user.name}</h3>
        <p>Email: ${user.email}</p>
        <p>Type: ${userType}</p>
        <button class="delete-btn">Delete User</button>
    `;

    const deleteBtn = userCard.querySelector(".delete-btn");
    deleteBtn.addEventListener("click", () => {
        deleteUser(user.id);
    });

    return userCard;
}



function deleteUser(userId) {
    const url = "admin_api.php?action=delete_user&user_id=" + userId;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the user card from the DOM
                const userCard = document.getElementById("user-" + userId);
                userCard.remove();
            } else {
                // Handle error
                alert("An error occurred while deleting the user. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the user. Please try again.");
        });
}


function fetchProperties() {
    const API_URL = "admin_api.php";
    const PROPERTY_ENDPOINT = "?action=get_properties";

    return fetch(API_URL + PROPERTY_ENDPOINT)
        .then((response) => response.json())
        .then((data) => {
            propertiesContainer.innerHTML = ""; // Clear existing property cards

            data.forEach((property) => {
                const propertyCard = createPropertyCard(property);
                propertiesContainer.appendChild(propertyCard);
            });
            return data;
        })
        .catch((error) => {
            console.error("Error fetching properties:", error);
        });
}

function fetchUsers() {
    const API_URL = "admin_api.php";
    const USER_ENDPOINT = "?action=get_users";

    return fetch(API_URL + USER_ENDPOINT)
        .then((response) => response.json())
        .then((data) => {
            usersContainer.innerHTML = ""; // Clear existing user cards

            data.forEach((user) => {
                const userCard = createUserCard(user);
                usersContainer.appendChild(userCard);
            });
            return data;
        })
        .catch((error) => {
            console.error("Error fetching users:", error);
        });
}


function fetchAnalyticsData() {
    fetch("admin_api.php?action=get_analytics_data")
        .then(response => response.json())
        .then(data => {
            console.log("Fetched analytics data:", data); // Add this line

            totalUsers.textContent = data.total_users;
            totalProperties.textContent = data.total_properties;

            if (typeof data.average_property_price === 'number') {
                averagePropertyPrice.textContent = data.average_property_price.toFixed(2);
            } else {
                console.error("Error: average_property_price is not a number");
            }

            // Update line graphs after fetching the data
            updateLineGraphs();
        })
        .catch(error => {
            console.error("Error fetching analytics data:", error);
        });
}

function deleteProperty(propertyId) {
    const url = "admin_api.php?action=delete_property&property_id=" + propertyId;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the property card from the DOM
                const propertyCard = document.getElementById("property-" + propertyId);
                propertyCard.remove();
            } else {
                // Handle error
                alert("An error occurred while deleting the property. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the property. Please try again.");
        });
}



function drawLineGraph(points, canvas) {
    const ctx = canvas.getContext("2d");
    const width = canvas.width;
    const height = canvas.height;

    // Clear the canvas
    ctx.clearRect(0, 0, width, height);

    if (points.length === 0) {
        return;
    }

    // Find the maximum Y value
    const maxY = Math.max(...points.map(point => point.y));

    // Calculate the scaling factor for Y axis
    const yScale = height / maxY;

    // Draw the line
    ctx.beginPath();
    ctx.moveTo(0, height - points[0].y * yScale);
    for (let i = 1; i < points.length; i++) {
        ctx.lineTo(i * (width / (points.length - 1)), height - points[i].y * yScale);
    }
    ctx.strokeStyle = "#007bff"; // Line color
    ctx.lineWidth = 2; // Line width
    ctx.stroke();
}


function updateLineGraphs() {
    const API_URL = "admin_api.php";
    const PROPERTY_ENDPOINT = "?action=get_properties";
    const USER_ENDPOINT = "?action=get_users";

    fetch(API_URL + PROPERTY_ENDPOINT)
        .then((response) => response.json())
        .then((properties) => {
            drawLineGraph(
                properties.map((property, index) => {
                    return {
                        x: index,
                        y: property.price,
                    };
                }),
                totalPropertyValueGraph
            );
        })
        .catch((error) => {
            console.error("Error fetching properties for graph:", error);
        });

        fetch(API_URL + USER_ENDPOINT)
        .then((response) => response.json())
        .then((users) => {
            let userCount = 0;
            drawLineGraph(
                users.map((user, index) => {
                    userCount += 1;
                    return {
                        x: index,
                        y: userCount, // Accumulate user count
                    };
                }),
                totalUsersGraph
            );
        })
        .catch((error) => {
            console.error("Error fetching users for graph:", error);
        });
    
}



function initializeEventListeners() {
    managePropertiesLink.addEventListener("click", function (e) {
        e.preventDefault();
        fetchProperties();

        propertiesSection.style.display = "block";
        usersSection.style.display = "none";
        analyticsSection.style.display = "none";
    });

    manageUsersLink.addEventListener("click", function (e) {
        e.preventDefault();
        fetchUsers();

        usersSection.style.display = "block";
        propertiesSection.style.display = "none";
        analyticsSection.style.display = "none";
    });

    viewAnalyticsLink.addEventListener("click", function (e) {
        e.preventDefault();
        fetchAnalyticsData();
        updateLineGraphs();

        analyticsSection.style.display = "block";
        usersSection.style.display = "none";
        propertiesSection.style.display = "none";
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Initialize event listeners
    initializeEventListeners();

    // Call these functions on page load
    fetchProperties();
    fetchAnalyticsData();
    updateLineGraphs();
});
