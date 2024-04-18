<?php
include "./config/database.php";

function selectIdByEmail($email, $conn){
    // Prepare the SQL statement with a placeholder for the email
    $sql = "SELECT * FROM users WHERE email = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the email parameter to the prepared statement
    $stmt->bind_param("s", $email);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch the row
    $row = $result->fetch_assoc();
    
    // Return the id
    return $row['Userid'];
}
?>