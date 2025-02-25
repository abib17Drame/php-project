<?php
require_once 'includes/db_connect.php';

$arbitre_id = $_GET['arbitre_id'];
$course_id = $_GET['course_id'];

$sql = "DELETE FROM arbitrage WHERE arbitre_id = ? AND course_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$arbitre_id, $course_id]);

header("Location: details_arbitre.php?id=" . $arbitre_id);
exit;
