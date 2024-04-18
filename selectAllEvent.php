<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include "./config/database.php";
    $sql = "select * from events";

    $result = $conn -> query($sql);

    $array = [];

    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
           
            $array[] = $row['Eventday'];
        }
    }

    echo json_encode($array);
}

?>