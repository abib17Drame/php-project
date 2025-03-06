<?php
require '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $athlete_id = $_POST['athlete_id'];
    $course_id = $_POST['course_id'];
    $temps = $_POST['temps'];
    $rang = $_POST['rang'];

    $sql = "UPDATE performances SET temps = '$temps', rang = '$rang' 
            WHERE athlete_id = '$athlete_id' AND course_id = '$course_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Performance mise à jour avec succès.";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>