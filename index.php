<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:mkoczorowskibaza.database.windows.net,1433; Database = zajecia4baza", "CloudSAef5d9c88", "{your_password_here}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "CloudSAef5d9c88", "pwd" => "{your_password_here}", "Database" => "zajecia4baza", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:mkoczorowskibaza.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
