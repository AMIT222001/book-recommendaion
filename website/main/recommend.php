<?php
require_once "../functions/database_functions.php";
require_once "../functions/rest_functions.php";

$conn = db_connect();

// Make sure $title is defined
// You can get it from GET/POST like this if needed
// $title = $_GET['title'] ?? '';

$get_data = callAPI('POST', 'http://127.0.0.1:5000/recommend_books', ['user_input' => $title]);

$response = json_decode($get_data, true);

if ($response && isset($response['recommendations'])) {
    foreach ($response['recommendations'] as $book) {
        $book_name = $book['book_name'];

        // Use a prepared statement to safely query the database
        $stmt = $conn->prepare("SELECT * FROM books WHERE book_title = ?");
        $stmt->bind_param("s", $book_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $query_row = $result->fetch_assoc()) {
            require "../template/book_container.php";
        } else {
            echo "Book not found in store: " . htmlspecialchars($book_name) . "<br>";
        }

        $stmt->close();  // Close the statement
    }
} else {
    echo "<p>⚠️ No recommendations found or API error occurred.</p>";
    var_dump($get_data);  // For debugging
}
?>
