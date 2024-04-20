<?php
include "../config/constants.php";
session_destroy();
header("location: " . ROOT_URL . "login/AccsessPage.php");
?>