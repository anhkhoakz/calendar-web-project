<?php
require 'constants.php';

// connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_errno($conn)) {
    die(mysqli_error($conn));
}
