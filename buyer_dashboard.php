<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <nav>
            <a href="#">Real Estate</a>
            <a href="index.php">Home</a>
            <a href="#">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
        <div class="search-filters">
            <div class="dropdown">
            <select id="homeType">
                <option value="Any">Any</option>
                <option value="House">House</option>
                <option value="Apartment">Apartment</option>
                <option value="Condo">Condo</option>
                <option value="Townhome">Townhome</option>
            </select>

            </div>
            <div class="dropdown">
                <button id="priceDropdown">Price</button>
                <div class="dropdown-content">
                    <label for="minPrice">Min Price</label>
                    <input type="number" id="minPrice" placeholder="0">
                    <label for="maxPrice">Max Price</label>
                    <input type="number" id="maxPrice" placeholder="1000000">
                    <button id="applyPrice">Apply</button>
                </div>
            </div>
            <div class="dropdown">
                <button>Bedrooms</button>
                <div class="dropdown-content">
                    <input type="checkbox" id="bedroom1" name="bedrooms" value="1"> 1 Bedroom<br>
                    <input type="checkbox" id="bedroom2" name="bedrooms" value="2"> 2 Bedrooms<br>
                    <input type="checkbox" id="bedroom3Plus" name="bedrooms" value="3+"> 3+ Bedrooms<br>
                    </div>
                </div>
                <div class="dropdown">
                <button>Bathrooms</button>
                <div class="dropdown-content">
                    <input type="checkbox" id="bathroom1" name="bathrooms" value="1"> 1 Bathroom<br>
                    <input type="checkbox" id="bathroom2" name="bathrooms" value="2"> 2 Bathrooms<br>
                    <input type="checkbox" id="bathroom3Plus" name="bathrooms" value="3+"> 3+ Bathrooms<br>
                </div>
            </div>

            <button id="updateFilters">Update Filters</button>
            <button id="resetFilters">Reset Filters</button>


        </div>
    </header>

    <main>
        <div class="sidenav">
            <a href="#">Link</a>
        </div>
        <div class="content">
            <h2>Buyer Dashboard</h2>
            <div class="properties-container" id="propertiesContainer">
                <!-- Property cards will be added here by JavaScript -->
            </div>
        </div>
    </main>

    <script src="buyer_dash.js"></script>
</body>
</html>
