<?php
include "connect.php";
$create_users =
"CREATE TABLE IF NOT EXISTS users
(
    ID INT NOT NULL AUTO_INCREMENT,
    Student No. INT(8) NOT NULL,
    Firstname TEXT(50) NOT NULL,
    Lastname TEXT(50) NOT NULL,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    School_College TEXT(50) NOT NULL,
    Position TEXT(50) NOT NULL,
    PRIMARY KEY(ID)
)";
$create_tbl = $conn->query($create_users);
// echo"USERS CREATED";
mysqli_close($conn);
?>