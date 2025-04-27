<?php
session_start();
include_once('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}


// Get data from AJAX request
$user_name = $_SESSION['username'];
$recipeId = $_POST['recipe_id'];

// Retrieve the current liked recipes
$sql = "SELECT liked_recipes FROM user_likes WHERE username='$user_name'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$likedRecipes = $row['liked_recipes'] ? explode(',', $row['liked_recipes']) : [];

// Check if the recipe is already liked
if (!in_array($recipeId, $likedRecipes)) {
    $likedRecipes[] = $recipeId;  // Add new recipe ID
}

// Update the liked recipes in the database
$updatedRecipes = implode(',', $likedRecipes);
$updateSql = "UPDATE user_likes SET liked_recipes='$updatedRecipes' WHERE username='$user_name'";

if (mysqli_query($conn, $updateSql)) {
    echo json_encode(['status' => 'success', 'message' => 'Recipe liked successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to like recipe']);
}
?>


