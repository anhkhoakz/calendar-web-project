<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./Account.php";

  $uId = selectIdByEmail($_SESSION['user_email'], $conn);
    $sql = "select * from events where Userid = $uId";

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