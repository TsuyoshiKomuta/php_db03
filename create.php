<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $birth_date = $_POST['birth_date'];
    $death_date = $_POST['death_date'] ? $_POST['death_date'] : NULL;
    $land = $_POST['land'] ? $_POST['land'] : NULL;
    $building = $_POST['building'] ? $_POST['building'] : NULL;
    $money = $_POST['money'] ? $_POST['money'] : NULL;

    // セッションにデータを保存
    $_SESSION['tiger'] = [
        'name' => $name,
        'address' => $address,
        'birth_date' => $birth_date,
        'death_date' => $death_date,
        'land' => $land,
        'building' => $building,
        'money' => $money
    ];

    // データベースに保存
    $stmt = $pdo->prepare("INSERT INTO characters (name, address, birth_date, death_date, land, building, money) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $address, $birth_date, $death_date, $land, $building, $money]);

    echo 'データが保存されました。';
}
