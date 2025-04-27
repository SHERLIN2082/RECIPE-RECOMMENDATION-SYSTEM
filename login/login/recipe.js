// const searchBtn = document.getElementById('search-btn');
// const searchInput = document.getElementById('search-input');
// const mealResult = document.getElementById('meal-result');

// const apiKey = 'ec4ca696cb274941b1043f7a8d764720'; // Replace with your Spoonacular API key
// //df3191bcd979458f835fc0dbe77e09dc
// //ec4ca696cb274941b1043f7a8d764720
// //a10ed584287049a9b766618ce62b670b
// // Fetch meals by ingredients
// searchBtn.addEventListener('click', async () => {
//   const query = searchInput.value.trim();
//   if (query) {
//     const response = await fetch(
//       `https://api.spoonacular.com/recipes/findByIngredients?ingredients=${query}&number=10&apiKey=${apiKey}`
//     );
//     const data = await response.json();
//     displayMeals(data);
//   }
// });

// // Display search results
// // function displayMeals(meals) {
// //   mealResult.innerHTML = '';
// //   meals.forEach(meal => {
// //     const mealItem = document.createElement('div');
// //     mealItem.className = 'meal-item';
// //     mealItem.innerHTML = `
// //       <img src="${meal.image}" alt="${meal.title}">
// //       <div class="meal-name">
// //         <h3>${meal.title}</h3>
// //         <a href="recipedetail.html?id=${meal.id}" class="recipe-btn">Get Recipe</a>
// //       </div>
// //     `;
// //     mealResult.appendChild(mealItem);
// //   });
// // }

// // function displayMeals(meals) {
// //   mealResult.innerHTML = '';
// //   meals.forEach(meal => {
// //     const mealItem = document.createElement('div');
// //     mealItem.className = 'recipe-card';
// //     mealItem.innerHTML = `
// //       <img src="${meal.image}" alt="${meal.title}" class="recipe-image">
// //       <div class="recipe-info">
// //         <h3 class="recipe-title">${meal.title}</h3>
// //         <div class="recipe-details">
// //           <span>Used ingredients: ${meal.usedIngredientCount}</span>
// //           <span>Missing: ${meal.missedIngredientCount}</span>
// //         </div>
// //       </div>
// //     `;
// //     mealItem.addEventListener('click', () => {
// //       window.location.href = `recipedetail.html?id=${meal.id}`;
// //     });
// //     mealResult.appendChild(mealItem);
// //   });
// // }


// function displayMeals(meals) {
//   mealResult.innerHTML = '';
//   meals.forEach(meal => {
//     const mealItem = document.createElement('div');
//     mealItem.className = 'recipe-card';
//     mealItem.innerHTML = `
//       <img src="${meal.image}" alt="${meal.title}" class="recipe-image">
//       <div class="recipe-info">
//         <h3 class="recipe-title">${meal.title}</h3>
//         <div class="recipe-details">
//           <span>Used ingredients: ${meal.usedIngredientCount}</span>
//           <span>Missing: ${meal.missedIngredientCount}</span>
//         </div>
//       </div>
//     `;
//     mealItem.addEventListener('click', () => {
//       window.location.href = `recipedetail.html?id=${meal.id}`;
//     });
//     mealResult.appendChild(mealItem);
//   });
// }

