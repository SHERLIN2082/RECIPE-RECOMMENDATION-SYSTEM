<?php
session_start();
include_once('connection.php');

if (!isset($_SESSION['name']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Spoonacular API Key - Replace with your actual API key
$spoonacular_api_key = 'df3191bcd979458f835fc0dbe77e09dc';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('image/bg3.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      overflow-y: auto;
    }

        .menu-title {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 40px;
        }
        .menu-highlight {
            color: #ffa500;
            font-style: italic;
            text-decoration: underline;
        }
        #recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        .recipe-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            text-decoration: none;
        }

        .recipe-card:hover {
            transform: translateY(-5px);

        }

        .recipe-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .recipe-info {
            padding: 20px;
        }

        .recipe-card h3 {
            font-size: 1.2em;
            color: #2c3e50;
            margin: 0 0 10px 0;
            text-decoration: none;
        }

        .recipe-details {
            display: flex;
            justify-content: space-between;
            color: #7f8c8d;
            font-size: 0.9em;
            text-decoration: none;
        }
/*         
        #recipe-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-top: 20px;
            padding: 0 20px;
        }
        .recipe-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
            text-decoration: none;
        }

        .recipe-card h3{
            text-align: center;
            margin-top: 10px;
        }
        a.recipe-card {
            text-decoration: none;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
        }
        .recipe-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .recipe-title {
            color: #ffa500;
            font-size: 1.5em;
            margin: 10px 0;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
        } */
        .loading {
            text-align: center;
            margin: 20px 0;
            font-size: 1.2em;
            color: #666;
        }
        .error-message {
            color: #ff0000;
            text-align: center;
            margin: 20px 0;
        }
        h1{
            font-size: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }
        h1 span{
            color: #fac031;
            margin-left: 15px;
            font-family: mv boli;
            text-decoration: None;

        }


    </style>
</head>
<body>
    <h1>Recipe<span>discover</span></h1>
    <div id="loading" class="loading">Loading recipes...</div>
    <div id="recipe-grid"></div>

    <script>
        const SPOONACULAR_API_KEY = '<?php echo $spoonacular_api_key; ?>';

        async function fetchRecipeDetails(recipeId) {
            try {
                const response = await fetch(
                    `https://api.spoonacular.com/recipes/${recipeId}/information?includeNutrition=true&apiKey=${SPOONACULAR_API_KEY}`
                );
                if (!response.ok) throw new Error('Recipe details not found');
                return await response.json();
            } catch (error) {
                console.error('Error fetching recipe details:', error);
                return null;
            }
        }

        async function loadRecipes() {
    const recipeGrid = document.getElementById('recipe-grid');
    const loadingDiv = document.getElementById('loading');
    
    try {
        const userEmail = "<?php echo addslashes($_SESSION['username']); ?>";
        const response = await fetch(`http://127.0.0.1:5000/recommend?user=${encodeURIComponent(userEmail)}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.text();
        console.log('API Response:', data);
        
        if (data && data.trim() !== '') {
            const recipeIds = data.includes(',') ? data.split(',') : [data];
            
            for (const id of recipeIds) {
                const recipe = await fetchRecipeDetails(id.trim());
                if (recipe) {
                    const card = `
                        <a href="recipedetail.html?id=${recipe.id}" class="recipe-card">
                        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                        <div class="recipe-info">
                            <h3 class="recipe-title">${recipe.title}</h3>
                            <div class="recipe-details">
                                <span><i class="fas fa-clock"></i> ${recipe.readyInMinutes} mins</span>
                                <span><i class="fas fa-fire"></i> ${Math.round(recipe.nutrition.nutrients[0].amount)} cal</span>
                            </div>

                        </div>
                    </div>
                    `;
                    recipeGrid.innerHTML += card;
                }
            }
        } else {
            recipeGrid.innerHTML = '<p>No recipes available at this time.</p>';
        }
    } catch (error) {
        console.error('Fetch Error:', error);
        recipeGrid.innerHTML = `
            <p class="error-message">
                Sorry, there was an error loading the recipes. Please try again later.<br>
                Error details: ${error.message}
            </p>
        `;
    } finally {
        loadingDiv.style.display = 'none';
    }
}

        window.onload = loadRecipes;
    </script>
</body>
</html>