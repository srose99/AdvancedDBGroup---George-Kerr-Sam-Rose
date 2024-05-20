<?php
require 'vendor/autoload.php'; 

$host = "localhost";
$port = "27017";
$dbname = "moviesdb";

// Create connection
$client = new MongoDB\Client("mongodb://$host:$port");
$db = $client->$dbname;
$collection = $db->movie;

// Function to display the contents of the movie collection
function displayCollection($collection) {
    $cursor = $collection->find();
    $cursor->rewind(); // Rewind the cursor before iterating over it

    if (!$cursor->valid()) {
        echo "No records found<br>";
    } else {
        echo "<table border='1'><tr><th>_id</th><th>MovieId</th><th>Title</th><th>Year</th><th>Genre</th><th>Summary</th><th>Artist</th><th>Country</th></tr>";
        foreach ($cursor as $document) {
            echo "<tr><td>" . $document["_id"] . "</td><td>" . $document["movieId"] . "</td><td>" . $document["title"] . "</td><td>" . $document["year"] . "</td><td>" . $document["genre"] . "</td><td>" . $document["summary"] . "</td><td>" . $document["artist"]["name"] . " " . $document["artist"]["surname"] . "</td><td>" . $document["country"]["name"] . "</td></tr>";
        }
        echo "</table><br>";
    }
}


// Inserting data
$insertResult = $collection->insertOne([
    'movieId' => 100,
    'title' => 'Titanic',
    'year' => 2024,
    'genre' => 'Drama',
    'summary' => 'test summary',
    'artist' => [
        'name' => 'George',
        'surname' => 'Lucas',
        'DOB' => '1944',
        'artistId' => 1
    ],
    'country' => [
        'code' => 'US',
        'name' => 'USA',
        'language' => 'english'
    ]
]);
if ($insertResult->getInsertedCount() > 0) {
    echo "New record inserted<br>";
    displayCollection($collection);
} else {
    echo "Error inserting record<br>";
}

// Updating data
$updateResult = $collection->updateOne(
    ['title' => 'Titanic'],
    ['$set' => ['genre' => 'Western']]
);
if ($updateResult->getModifiedCount() > 0) {
    echo "Record updated<br>";
    displayCollection($collection);
} else {
    echo "Error updating record<br>";
}

// Deleting data
$deleteResult = $collection->deleteOne(['title' => 'Titanic']);
if ($deleteResult->getDeletedCount() > 0) {
    echo "Record deleted<br>";
    displayCollection($collection);
} else {
    echo "Error deleting record<br>";
}

// Performing an aggregation
$pipeline = [
    ['$match' => ['genre' => 'Drama']]
];

$aggregationResult = $collection->aggregate($pipeline);
echo "Aggregation results:<br>";

if ($aggregationResult !== null) {
    $aggregationData = iterator_to_array($aggregationResult);
    if (!empty($aggregationData)) {
        echo "<table border='1'><tr><th>_id</th><th>MovieId</th><th>Title</th><th>Year</th><th>Genre</th><th>Summary</th><th>Artist</th><th>Country</th></tr>";
        foreach ($aggregationData as $document) {
            echo "<tr><td>" . $document["_id"] . "</td><td>" . $document["movieId"] . "</td><td>" . $document["title"] . "</td><td>" . $document["year"] . "</td><td>" . $document["genre"] . "</td><td>" . $document["summary"] . "</td><td>" . $document["artist"]["name"] . " " . $document["artist"]["surname"] . "</td><td>" . $document["country"]["name"] . "</td></tr>";
        }
        echo "</table><br>";
    } else {
        echo "No records found in the aggregation<br>";
    }
} else {
    echo "Error executing aggregation query<br>";
}

?>
