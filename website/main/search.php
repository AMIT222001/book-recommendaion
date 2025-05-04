<?php
    require_once "../functions/database_functions.php";
    db_connect();
    require_once "bootstrap.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <style>
        thead {
            background-color: black;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .search-heading {
            margin: 30px 0;
        }
    </style>
</head>
<body>

<h1 class="display-1 blockquote text-center search-heading">Search Results</h1>

<div class="container">
<?php
    // Get query parameter
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $min_length = 3; // Minimum length requirement

    if (strlen($query) >= $min_length) {
        
        $query = htmlspecialchars($query); // Avoid HTML injection

        // Prepare the query using MySQLi
        $conn = mysqli_connect("localhost", "root", "", "dbms_online");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM books WHERE book_title LIKE ? OR book_author LIKE ? ORDER BY book_title");
        $search_query = "%" . $query . "%";
        $stmt->bind_param("ss", $search_query, $search_query);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>Search Results for: <strong>" . htmlspecialchars($query) . "</strong></h2>";
            echo "<table class='table'>";
            echo "<thead class='thead-light'>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'><h3><i>Book</i></h3></th>
                    </tr>
                  </thead>
                  <tbody>";

            $count = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <th scope='row'>" . $count++ . "</th>
                        <td>
                            <a href='book.php?bookisbn=" . urlencode($row['book_isbn']) . "'>
                                <h3>" . htmlspecialchars($row['book_title']) . "</h3>
                                <p>" . htmlspecialchars($row['book_author']) . "</p>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</tbody></table>";

        } else {
            // No results found
            echo "<div class='alert alert-danger display-4 text-center'>No Items Found</div>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

    } else {
        // Query too short
        echo "<div class='alert alert-warning display-4 text-center'>No results found. Minimum length of query is 3.</div>";
        echo "<div class='text-center'><a href='books.php' class='btn btn-info'>Back to Catalogs</a></div>";
    }
?>
</div>

</body>
</html>
