<?php
session_start();
include_once('connection.php');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$username = $_SESSION['username'];
$recipe_id = $_POST['recipe_id'];

// Check if the recipe is liked by the user
$sql = "SELECT liked_recipes FROM user_likes WHERE username = '$username' AND FIND_IN_SET('$recipe_id', liked_recipes) > 0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(['status' => 'liked']);
} else {
    echo json_encode(['status' => 'not_liked']);
}
?>
