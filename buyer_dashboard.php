<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "buyer") {
    header("Location: index.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<main>
    <div class="sidenav">
        <div class="search-filters">
        <p id="welcomeMessage">Welcome <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            <div>
                <span>Home Type:</span>
                <label><input type="radio" name="propertyType" value="Any" checked> Any</label>
                <label><input type="radio" name="propertyType" value="House"> House</label>
                <label><input type="radio" name="propertyType" value="Apartment"> Apartment</label>
                <label><input type="radio" name="propertyType" value="Condo"> Condo</label>
                <label><input type="radio" name="propertyType" value="Townhouse"> Townhouse</label>
            </div>

            <div>
                <label for="minPrice">Min Price</label>
                <input type="number" id="minPrice" placeholder="0" style="width: 48%;">
                <label for="maxPrice">Max Price</label>
                <input type="number" id="maxPrice" placeholder="1000000" style="width: 48%;">
            </div>
            <div>
                <span>Bedrooms:</span>
                <label><input type="checkbox" name="bedrooms" value="1"> 1</label>
                <label><input type="checkbox" name="bedrooms" value="2"> 2</label>
                <label><input type="checkbox" name="bedrooms" value="3+"> 3+</label>
            </div>
            <div>
                <span>Bathrooms:</span>
                <label><input type="checkbox" name="bathrooms" value="1"> 1</label>
                <label><input type="checkbox" name="bathrooms" value="2"> 2</label>
                <label><input type="checkbox" name="bathrooms" value="3+"> 3+</label>
            </div>
            <button id="updateFilters">Update Filters</button>
            <button id="resetFilters">Reset Filters</button>
        </div>
        <a href="#" id="favoritesLink">Favorites</a>
    </div>
    <div class="content">
        <h2>Buyer Dashboard</h2>
        <div class="properties-container" id="propertiesContainer">
            <!-- Property cards will be added here by JavaScript -->
        </div>
        <div id="pagination" class="pagination">
            <!-- Pagination buttons will be added here by JavaScript -->
        </div>
    </div>
</main>

<div id="propertyModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-image-text-container">
            <img id="modalImage" src="" alt="">
            <div class="modal-text">
                <h2 id="modalAddress"></h2>
                <ul id="modalDetails"></ul>
                <p id="modalDescription"></p>
            </div>
        </div>
    </div>
</div>

<div id="favoritedPropertiesModal" class="modal">
  <div class="modal-content">
    <span id="favoritesModalClose" class="close">&times;</span>
    <h2>Favorited Properties</h2>
    <div id="favoritedPropertiesContainer" class="properties-container">
      <!-- Favorited properties will be displayed here -->
    </div>
  </div>
</div>



<script src="buyer_dash.js"></script>
</body>
</html>
