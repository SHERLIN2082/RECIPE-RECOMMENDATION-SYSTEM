
const searchBtn = document.getElementById('search-btn');
const searchInput = document.getElementById('search-input');
const mealResult = document.getElementById('meal-result');

const apiKey = 'ec4ca696cb274941b1043f7a8d764720';

searchBtn.addEventListener('click', async () => {
  const query = searchInput.value.trim();
  if (query) {
    const response = await fetch(
      `https://api.spoonacular.com/recipes/complexSearch?query=${query}&addRecipeNutrition=true&number=10&apiKey=${apiKey}`
    );
    const data = await response.json();
    displayMeals(data.results);
  }
});

function displayMeals(meals) {
  mealResult.innerHTML = '';
  meals.forEach(meal => {
    const mealItem = document.createElement('div');
    mealItem.innerHTML = `
      <a href="recipedetail.html?id=${meal.id}" class="recipe-card">
        <img src="${meal.image}" alt="${meal.title}" class="recipe-image">
        <div class="recipe-info">
          <h3 class="recipe-title">${meal.title}</h3>
          <div class="recipe-details">
            <span><i class="fas fa-clock"></i> ${meal.readyInMinutes} mins</span>
            <span><i class="fas fa-fire"></i> ${Math.round(meal.nutrition.nutrients[0].amount)} cal</span>
          </div>
        </div>
      </a>
    `;
    mealResult.appendChild(mealItem);
  });
}