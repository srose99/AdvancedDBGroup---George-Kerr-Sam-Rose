<?php
$servername = "localhost:3306";
$username = "root";
$password = "c2fc7eaf36";
$dbname = "moviesdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to display the contents of the movie table
function displayTable($conn) {
    $sql = "SELECT * FROM movie";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>MovieId</th><th>Title</th><th>Year</th><th>Genre</th><th>Summary</th><th>ArtistId</th><th>CountryCode</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["movieId"] . "</td><td>" . $row["title"] . "</td><td>" . $row["year"] . "</td><td>" . $row["genre"] . "</td><td>" . $row["summary"] . "</td><td>" . $row["artistId"] . "</td><td>" . $row["countryCode"] . "</td></tr>";
        }
        echo "</table><br>";
    } else {
        echo "No records found<br>";
    }
}

// Inserting data
$sql_insert_data = "INSERT INTO movie (movieId, title, year, genre, summary, artistId, countryCode) VALUES ('100', 'Titanic', 2024, 'Drama', 'test summary', '40', 'US')";
if ($conn->query($sql_insert_data) === TRUE) {
    echo "New record inserted<br>";
    displayTable($conn);
} else {
    echo "Error inserting record: " . $conn->error . "<br>";
}

// Updating data
$sql_update_data = "UPDATE movie SET genre = 'Western' WHERE title = 'Titanic'";
if ($conn->query($sql_update_data) === TRUE) {
    echo "Record updated<br>";
    displayTable($conn);
} else {
    echo "Error updating record: " . $conn->error . "<br>";
}

// Deleting data
$sql_delete_data = "DELETE FROM movie WHERE title = 'Titanic'";
if ($conn->query($sql_delete_data) === TRUE) {
    echo "Record deleted<br>";
    displayTable($conn);
} else {
    echo "Error deleting record: " . $conn->error . "<br>";
}

// Creating a view
$sql_create_view = "CREATE VIEW my_view AS SELECT * FROM movie WHERE genre = 'Drama'";
if ($conn->query($sql_create_view) === TRUE) {
    echo "View created<br>";

    // Fetch data from the view
    $sql_view_data = "SELECT * FROM my_view";
    $result = $conn->query($sql_view_data);
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>MovieId</th><th>Title</th><th>Year</th><th>Genre</th><th>Summary</th><th>ArtistId</th><th>CountryCode</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["movieId"] . "</td><td>" . $row["title"] . "</td><td>" . $row["year"] . "</td><td>" . $row["genre"] . "</td><td>" . $row["summary"] . "</td><td>" . $row["artistId"] . "</td><td>" . $row["countryCode"] . "</td></tr>";
        }
        echo "</table><br>";
    } else {
        echo "No records found in the view<br>";
    }

    // Deleting the view
    $sql_drop_view = "DROP VIEW my_view";
    if ($conn->query($sql_drop_view) === TRUE) {
        echo "View deleted<br>";
    } else {
        echo "Error deleting view: " . $conn->error . "<br>";
    }
} else {
    echo "Error creating view: " . $conn->error . "<br>";
}

$conn->close();
?>
