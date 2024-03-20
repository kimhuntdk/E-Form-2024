<?php
session_start();
require_once("inc/db_connect.php");
$mysqli = connect();

if (isset($_POST['update']) || isset($_POST['update_all'])) {
    if (isset($_POST['update_all'])) {
        // อัปเดตทุกประเภทของเอกสาร
        foreach ($_POST['openTime'] as $docTypeId => $openTime) {
            $closeTime = $_POST['closeTime'][$docTypeId];
            // อัปเดตแต่ละประเภทของเอกสาร
            $updateSql = "UPDATE request_doc_type SET OpenTime = ?, CloseTime = ? WHERE doc_type_id = ?";
            $stmtAll = $mysqli->prepare($updateSql);
            $stmtAll->bind_param("ssi", $openTime, $closeTime, $docTypeId);
            $stmtAll->execute();
            $stmtAll->close();
        }
    } else {
        // อัปเดตแต่ละประเภทของเอกสาร
        foreach ($_POST['openTime'] as $docTypeId => $openTime) {
            $closeTime = $_POST['closeTime'][$docTypeId];
            // อัปเดตแต่ละประเภทของเอกสาร
            $updateSql = "UPDATE request_doc_type SET OpenTime = ?, CloseTime = ? WHERE doc_type_id = ?";
            $stmt = $mysqli->prepare($updateSql);
            $stmt->bind_param("ssi", $openTime, $closeTime, $docTypeId);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Redirect กลับไปยังหน้าเดิม
header("Location: form_setTime.php");
exit();
?>
