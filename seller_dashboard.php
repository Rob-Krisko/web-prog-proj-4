<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "seller") {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION["user_id"];

$sql = "SELECT * FROM properties WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include("header.php"); ?>

    <main>
        <h2>Seller Dashboard</h2>
        <section class="my-properties-container">
            <h4>My Properties</h4>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="property-card" data-property-id="<?php echo $row['id']; ?>">
                    <img src="property_images/<?php echo $row['image'] ? $row['image'] : 'default.jpg'; ?>" alt="Property Image">
                    <div class="property-info">
                        <h5><?php echo $row["address"]; ?></h5>
                        <p>$<?php echo number_format($row["price"]); ?></p>
                    </div>
                    <button class="delete-property-btn">Remove</button>
                </div>
            <?php endwhile; ?>

            <div class="property-card add-property">
                <a href="new_property.html">
                    <img src="property_images/add_property_icon.png" alt="Add Property">
                </a>
            </div>
        </section>
        <div id="property-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePropertyModal();">&times;</span>
                <h3 id="modal-address"></h3>
                <p id="modal-price"></p>
                <p id="modal-bedrooms"></p>
                <p id="modal-bathrooms"></p>
                <p id="modal-type"></p>
                <p id="modal-area"></p>
                <p id="modal-year_built"></p>
                <p id="modal-description"></p>
            </div>
        </div>

    </main>

    <div id="add-property-modal" class="modal add-property-modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddPropertyModal();">&times;</span>
            <h3>Add New Property</h3>
            <form id="add-property-form" enctype="multipart/form-data">
                <div>
                    <label for="address">Address *</label>
                    <input type="text" id="address" name="address" placeholder="123 Main St" required>
                </div>
                <div>
                    <label for="price">Price *</label>
                    <input type="number" id="price" name="price" placeholder="0" required>
                </div>
                <div>
                    <label for="bedrooms">Bedrooms *</label>
                    <input type="number" id="bedrooms" name="bedrooms" placeholder="0" required>
                </div>
                <div>
                    <label for="bathrooms">Bathrooms *</label>
                    <input type="number" id="bathrooms" name="bathrooms" placeholder="0" required>
                </div>
                <div>
                    <label for="image">Property Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <div>
                    <label for="type">Property Type</label>
                    <select id="type" name="type">
                        <option value="house" selected>House</option>
                        <option value="apartment">Apartment</option>
                        <option value="condo">Condo</option>
                        <option value="townhouse">Townhouse</option>
                    </select>
                </div>
                <div>
                    <label for="area">Area (sq ft)</label>
                    <input type="number" id="area" name="area" placeholder="0">
                </div>
                <div>
                    <label for="year_built">Year Built</label>
                    <input type="number" id="year_built" name="year_built" placeholder="2000">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Write a brief description of the property"></textarea>
                </div>
                <button type="submit">Add Property</button>
            </form>
        </div>
    </div>


    <script src="dash.js"></script>
    <footer>
        <p>&copy; 2023 Boxed Estates. All rights reserved.</p>
    </footer>

    </body>
</html>


<?php
$stmt->close();
$conn->close();
?>
