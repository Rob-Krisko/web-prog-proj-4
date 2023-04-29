<?php include './header.php';
session_start();


$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<html>

<head>
    <link rel='stylesheet' href='./admin.css'>
</head>

<body>

    <div class='side-nav'>
        <a href='./buyer_dashboard.php'>Buyer Dashboard</a>
        <a href='./seller_dashboard.php'>Seller Dashboard</a>
        <a href='#remove'>Remove Listing</a>
    </div>

    <div class='content'>
        <h1>Hello,
            <?php echo $_SESSION["name"] ?>
        </h1>

        <div class='idk'>
            <div class='property-num'>
                <h2> total number of properties: </h2>
                <h3>
                <?php
                $servername = "localhost";
                $username = "rkrisko1";
                $password = "rkrisko1";
                $dbname = "rkrisko1";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * from properties";
                if ($result = mysqli_query($conn, $sql)) {
                    $rowcount = mysqli_num_rows($result);

                    printf("%d", $rowcount);
                }

                /*
                $result = $conn->query("SELECT COUNT(*) FROM properties")->fetch_array();
                var_dump($result[0]);
                */

                ?>
                </h3>

            </div>

            <div class='total-value'>
                <h2>total value on the market: </h2>
                <h3>
                <?php



                $result = mysqli_query($conn, "SELECT SUM(price) FROM properties");
                while ($row = mysqli_fetch_array($result)) {
                    echo "$" . $row['SUM(price)'];
                }

                ?>
                </h3>
            </div>
        </div>


        <div class='db-list'>
            <h2>List of Database:</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Address</th>
                    <th>Price</th>
                    <th>Bedrooms</th>
                    <th>Bathrooms</th>
                    <th>Property Type</th>
                    <th>Year Built</th>
                    <th>Sqft</th>
                    <th>created at</th>
                </tr>
                <?php

                $sql = "SELECT * FROM properties";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["address"] . "</td><td>" . $row["price"] . "</td><td>" . $row["bedrooms"] . "</td><td>" . $row["bathrooms"] . "</td><td>" . $row["property_type"] . "</td><td>" . $row["year_built"] . "</td><td>" . $row["sqft"] . "</td><td>" . $row["created_at"] . "</td><tr>";
                    }
                } else {
                    echo "no results";
                }


                ?>


            </table>
        </div>

        <div class='user-list'>
            <h2>List of Users:</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>User Type</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Created</th>
                </tr>
                <?php

                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["user_type"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["username"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["created_at"] . "</td><tr>";
                    }
                } else {
                    echo "no results";
                }


                ?>

            </table>
        </div>

        <div class='remove-listing' id='remove'>
        <h2>Delete Listing</h2>
            <form action='#' method='POST'>
                <p>Please type the ID in to remove Listing</p>
                <input type='text' name='id'></input>
                <input type='submit'></input>
            </form>
        </div>

    </div>



</body>

</html>



<?php $conn->close(); ?>