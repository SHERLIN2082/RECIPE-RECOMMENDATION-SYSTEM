from flask import Flask, jsonify, request
import pandas as pd
import json
from sklearn.neighbors import NearestNeighbors
from flask_cors import CORS  # Add this import

# Initialize Flask app
app = Flask(__name__)
CORS(app)
# Step 1: Load JSON Data
with open('Database/likes_data.json') as f:
    data = json.load(f)

# Step 2: Extract All Unique Recipes and Create User-Recipe Matrix
all_recipes = sorted({int(recipe) for recipes in data.values() for recipe in recipes})

# Function to convert a user's liked recipes into a binary vector
def create_binary_vector(user_liked_recipes, all_recipes):
    return [1 if str(recipe) in user_liked_recipes else 0 for recipe in all_recipes]

# Create the user-recipe matrix
user_recipe_matrix = pd.DataFrame(
    [create_binary_vector(liked_recipes, all_recipes) for liked_recipes in data.values()],
    index=data.keys(),
    columns=all_recipes
)

print("User-Recipe Matrix:\n", user_recipe_matrix)

# Step 3: Train the KNN Model
knn = NearestNeighbors(metric='cosine', algorithm='brute')
knn.fit(user_recipe_matrix)

# Step 4: Recommendation Function
def recommend_recipes(user, n_recommendations=2):
    user_index = user_recipe_matrix.index.get_loc(user)
    user_vector = user_recipe_matrix.iloc[user_index].values.reshape(1, -1)

    # Find the nearest neighbor (excluding the user itself)
    distances, indices = knn.kneighbors(user_vector, n_neighbors=2)

    similar_user_index = indices[0][1]  # Get the most similar user (excluding the target user)
    similar_user = user_recipe_matrix.index[similar_user_index]

    # Get recipes liked by the similar user but not the target user
    similar_user_likes = set(data[similar_user])
    target_user_likes = set(data[user])

    recommended_recipes = list(similar_user_likes - target_user_likes)
    return recommended_recipes[:n_recommendations]

# Step 5: Create a Flask Route to Serve Recommendations
@app.route('/recommend', methods=['GET'])
# def recommend():
#     user = request.args.get('user')  # Get the 'user' from query params
#     if user not in data:
#         return jsonify({'error': 'User not found'}), 404

#     recommendations = recommend_recipes(user)
#     recommendations = ",".join([str(ele) for ele in recommendations])
#     print(recommendations)

#     return recommendations  # Return recommendations as a JSON object

def recommend():
    user = request.args.get('user')
    if user not in data:
        return jsonify({'error': 'User not found'}), 404

    recommendations = recommend_recipes(user)
    recommendations = ",".join([str(ele) for ele in recommendations])
    print(recommendations)

    # Add proper response headers
    response = app.make_response(recommendations)
    response.headers['Content-Type'] = 'text/plain'
    return response

# Run the Flask app
if __name__ == '__main__':
    app.run(debug=True)
