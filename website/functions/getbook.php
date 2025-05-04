<?php

function get_book_description($book_title) {
    // URL to make a request to Google Books API
    $url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($book_title);
    
    // Using file_get_contents to send a GET request to the API
    $response = file_get_contents($url);
    
    // Check if response is valid
    if ($response === FALSE) {
        return "Error fetching book information.";
    }
    
    // Decode the JSON response from Google Books API
    $data = json_decode($response, true);
    
    // Check if any book is found
    if (isset($data['items']) && count($data['items']) > 0) {
        // Get the first book from the response (you can modify this to handle multiple books)
        $book = $data['items'][0];
        
        // Extract book title and description
        $book_title = isset($book['volumeInfo']['title']) ? $book['volumeInfo']['title'] : 'No title found';
        $book_description = isset($book['volumeInfo']['description']) ? $book['volumeInfo']['description'] : 'No description available';
        
        // Return the book description
        return "Title: $book_title\n\nDescription: $book_description";
    } else {
        return "No book found with the title '$book_title'.";
    }
}

// Example usage:
// $book_title = "The Great Gatsby"; // Replace this with any book title you want
// $description = get_book_description($book_title);
// echo nl2br($description); // Outputs the description of the book

?>
