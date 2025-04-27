<?php
session_start();
include_once('connection.php');

// Check if the session variables exist
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="style copy.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Dropdown Styling */
        .user-menu {
            position: absolute;
            top: 70px;
            right: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .user-menu a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
        }

        .user-menu a:hover {
            background-color: #f0f0f0;
        }

        .icon {
            position: relative;
            cursor: pointer;
        }
        blockquote {
            font-size: 1.5rem;
            font-style: italic;
            color: #555;
            margin: 20px 0;
            padding: 10px;
            border-left: 5px solid #ccc;
            background-color: #f9f9f9;
            line-height: 1.6;
        }

        .quote-author {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }
        
    </style>
</head>
<body>

<section id="Home">
    <nav>
        <div class="logo">
            <img src="image/logo.png">
        </div>

        <ul>
            <li><a href="#Home">Home</a></li>
            <li><a href="recipe.html">Recipe</a></li>
            <li><a href="discover.php">Discover</a></li>
            <li><a href="cuisine.html">Cuisine</a></li>
            <li><a href="diet.html">Diet</a></li>
            <li>Contact</li>
        </ul>

        <div class="icon" id="userIcon">
            <i class="fa-solid fa-user"></i>
            <!-- Dropdown Menu -->
            <div class="user-menu" id="userMenu">
                <a href="#"><span id="usernameDisplay"><?php echo htmlspecialchars($username); ?></span></a>
                <a href="index.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main">
        <div class="men_text">
            <!-- <h1>Get Fresh<span>Food</span><br>in an Easy Way</h1> -->
            <h1>Real <span>food</span><br>doesn't<span>have</span> ingredients,<br>real food is <span>ingredients</span></h1>
        </div>



        <div class="main_image">
            <img src="image/main_img.png">
        </div>
    </div>

    <div class="main_btn">
        <a href="cuisine.html">Explore</a>
        <i class="fa-solid fa-angle-right"></i>
    </div>

</section>

<script>
          function fetchLikesData() {
            fetch('fetch_likes.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data);
                    if (data.message) {
                        alert(data.message); // Show success message
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        };
    // Toggle the user menu on icon click
    const userIcon = document.getElementById('userIcon');
    const userMenu = document.getElementById('userMenu');

    userIcon.addEventListener('click', () => {
        userMenu.style.display = userMenu.style.display === 'none' || userMenu.style.display === '' 
            ? 'block' : 'none';
    });

    // Hide menu if clicked outside
    window.addEventListener('click', (e) => {
        if (!userIcon.contains(e.target)) {
            userMenu.style.display = 'none';
        }
    });
    window.onload = fetchLikesData;
</script>

</body>
</html>
