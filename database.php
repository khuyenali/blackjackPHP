<?php

$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Make my_db the current database
$db_selected = mysqli_select_db($link, 'blackjack');

if (!$db_selected) {
    // If we couldn't, then it either doesn't exist, or we can't see it.
    $sql = 'CREATE DATABASE blackjack';

    if (mysqli_query($link, $sql)) {
        echo "Database my_db created successfully\n";
        mysqli_select_db($link, 'blackjack');
    } else {
        echo 'Error creating database: ' . mysqli_error($link);
    }
}

$sql = 'CREATE TABLE player( id CHARACTER(50), password CHARACTER(50), chips int ,PRIMARY KEY(id) )';

if (mysqli_query($link, $sql)) {
    echo "Table create successfully.";
} else {
    // echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

