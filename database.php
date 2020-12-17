<?php

$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    die('Could not connect: ' . $conn->connect_error);
}

// Make my_db the current database
// $db_selected = mysqli_select_db($link, 'blackjack');

if (!$conn->select_db('blackjack')) {
    // If we couldn't, then it either doesn't exist, or we can't see it.
    $sql = 'CREATE DATABASE blackjack';

    if ($conn->query($sql)) {
        echo "Database my_db created successfully\n";
        // mysqli_select_db($link, 'blackjack');
        $conn->select_db('blackjack');
    } else {
        echo 'Error creating database: ' . $conn->error;
    }
}

$sql = 'CREATE TABLE player( id CHARACTER(50), password CHARACTER(50), chips int ,PRIMARY KEY(id) )';

if ($conn->query($sql)) {
    echo "Table create successfully.";
} else {
    // echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

