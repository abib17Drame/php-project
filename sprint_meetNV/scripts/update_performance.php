<?php
require '../includes/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $athlete_id = $_POST['athlete_id'];
    $course_id = $_POST['course_id'];
    $temps = $_POST['temps'];
    $rang = $_POST['rang'];

    $sql = "UPDATE performances SET temps = ?, rang = ? WHERE athlete_id = ? AND course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $temps, $rang, $athlete_id, $course_id);
    if ($stmt->execute()) {
        echo "Performance mise à jour avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
}
?>