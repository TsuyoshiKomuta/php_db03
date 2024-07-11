<?php
session_start();
require 'db.php';

$id = $_POST['id'];

// トラのデータを削除する場合、セッションデータも削除
if (isset($_SESSION['tiger']) && $_SESSION['tiger']['id'] == $id) {
    unset($_SESSION['tiger']);
}

// データベースからデータを削除
$sql = "DELETE FROM characters WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo "データが削除されました。";
