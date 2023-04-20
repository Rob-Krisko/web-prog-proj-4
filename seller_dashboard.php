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

    <script src="dash.js"></script>
    <?php include("footer.php"); ?>

<?php
$stmt->close();
$conn->close();
?>
