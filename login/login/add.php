<?php
include_once('connection.php');

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pass = md5($_POST['password']);

    // Insert into tbl_user
    $sql = "INSERT INTO `tbl_user`(`name`, `username`, `password`) VALUES ('$name', '$username', '$pass')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Get the last inserted user ID
        $user_id = mysqli_insert_id($conn);

        // Insert into user_likes using the foreign key
        $sql_likes = "INSERT INTO `user_likes`(`user_id`, `username`) VALUES ('$user_id', '$username')";
        $result_likes = mysqli_query($conn, $sql_likes);

        if ($result_likes) {
            echo "<script>alert('New User Registered Successfully');</script>";
            header('location:index.php');
            exit; // Ensure no further code is executed after redirect
        } else {
            die(mysqli_error($conn));
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>
