<?php
session_start();
require_once("inc/db_connect.php");
$mysqli = connect();

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT COUNT(*) AS total_count FROM `request_doc` WHERE doc_type = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo "<h4>".$row['total_count']."</h4>";
}
?>
