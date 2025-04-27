
<?php
// Database connection settings
$host = 'localhost'; // Your database host
$dbname = 'login_register_db'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user and liked recipes
$sql = "SELECT username, liked_recipes FROM user_likes";
$result = $conn->query($sql);

// Initialize an array to store the data
$data = [];

// Process the result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Split the liked_recipes into an array
        $liked_recipes = explode(',', $row['liked_recipes']);

        // If the user already exists in the array, merge the new recipes
        if (isset($data[$row['username']])) {
            $data[$row['username']] = array_merge(
                $data[$row['username']],
                array_map('trim', $liked_recipes) // Trim and merge
            );
        } else {
            // Otherwise, initialize the user's recipes
            $data[$row['username']] = array_map('trim', $liked_recipes);
        }
    }
}

// Convert the grouped data into a JSON-compatible format
$formatted_data = [];
foreach ($data as $username => $recipes) {
    $formatted_data[] = [
        'username' => $username,
        'liked_recipes' => $recipes
    ];
}


// Close the connection
$conn->close();

// Set the content type to application/json
header('Content-Type: application/json');

// Convert data to JSON
$json_data = json_encode($data);

// Define the directory where the file will be saved
$directory = 'C:\\xampp\\htdocs\\login\\Database\\'; // Change this to your target directory
$file_name = 'likes_data.json';

// Save the JSON data to a file
if (!is_dir($directory)) {
    mkdir($directory, 0755, true); // Create directory if it doesn't exist
}

file_put_contents($directory . $file_name, $json_data);

// Optionally, return a response indicating success
echo json_encode(['message' => 'Data saved successfully', 'file' => $file_name]);
?>
