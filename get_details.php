<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['name'])) {
    $name = $_GET['name'];

    // データベースからデータを取得
    $stmt = $pdo->prepare("SELECT * FROM characters WHERE name = ?");
    $stmt->execute([$name]);
    $character = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($character) {
        // セッションにデータを保存
        $_SESSION['tiger'] = [
            'id' => $character['id'],
            'name' => $character['name'],
            'address' => $character['address'],
            'birth_date' => $character['birth_date'],
            'death_date' => $character['death_date'],
            'land' => $character['land'],
            'building' => $character['building'],
            'money' => $character['money']
        ];

        echo json_encode($character);
    } else {
        echo json_encode(['error' => 'データが見つかりませんでした。']);
    }
}
