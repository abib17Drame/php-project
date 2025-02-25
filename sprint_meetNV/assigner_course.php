<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arbitre_id = $_POST['arbitre_id'];
    $course_id = $_POST['course_id'];

    $sql = "INSERT INTO arbitrage (arbitre_id, course_id) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$arbitre_id, $course_id]);

    header("Location: details_arbitre.php?id=" . $arbitre_id);
    exit;
}
