<?php
if (isset($_GET["ID"])) {
    $ID = $_GET["ID"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Myshop";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM clients WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $ID); 
    $stmt->execute();

    $stmt->close();
    $connection->close();
}

header("Location: /MYSHOP/index.php");
exit;
?>