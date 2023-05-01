<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "admin") {
    header("Location: index.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<main>
    <div class="sidenav">
        <p id="welcomeMessage">Welcome <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        <a href="#" id="managePropertiesLink">Manage Properties</a>
        <a href="#" id="manageUsersLink">Manage Users</a>
        <a href="#" id="viewAnalyticsLink">View Analytics</a>
    </div>
    <div class="content">

        <!-- Update Property Modal -->
        <div class="modal" id="updatePropertyModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Property Details</h2>
            <form id="updatePropertyForm">
            <!-- Add form fields to update property details here -->
            <button type="submit">Update</button>
            </form>
        </div>
        </div>

        <!-- Remove User Modal -->
        <div class="modal" id="removeUserModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Are you sure you want to remove this user?</h2>
            <form id="removeUserForm">
            <!-- Add a hidden input field to store user ID -->
            <input type="hidden" id="removeUserId" name="user_id">
            <button type="submit">Yes, remove</button>
            </form>
        </div>
        </div>

        <h2>Admin Dashboard</h2>
        <div id="adminDashboardContent">
            <!-- Content for managing properties, users, and analytics will be loaded here -->
            <div class="analytics-container" id="analyticsSection">
                <div>
                    <span>Total Users:</span>
                    <span id="totalUsers">0</span>
                </div>
                <div>
                    <span>Total Properties:</span>
                    <span id="totalProperties">0</span>
                </div>
                <div>
                    <span>Average Property Price:</span>
                    <span id="averagePropertyPrice">$0</span>
                </div>
            </div>
            <div class="line-graphs-container">
                <div class="line-graph">
                    <h3>Total Property Value</h3>
                    <canvas id="totalPropertyValueGraph"></canvas>
                </div>
                <div class="line-graph">
                    <h3>Total Users</h3>
                    <canvas id="totalUsersGraph"></canvas>
                </div>
            </div>
            <div id="propertiesSection" style="display: none;">
                <div id="propertiesContainer">
                    <!-- Property cards will be inserted here -->
                </div>
            </div>
            <div id="usersSection" style="display: none;">
                <div id="usersContainer">
                    <!-- User cards will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</main>

<script src="admin_dash.js"></script>
</body>
</html>
