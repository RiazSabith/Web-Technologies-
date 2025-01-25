<?php
// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'booklibrary'; 

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<p style='text-align: center; color: red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data and sanitize it
    $isbn = trim($_POST['isbn']);
    $book_name = trim($_POST['book_name']);
    $author_name = trim($_POST['author_name']);
    $price = trim($_POST['price']);
    $book_copy = trim($_POST['book_copy']);

    // Input validation
    if (empty($isbn) || empty($book_name) || empty($author_name) || empty($price) || empty($book_copy)) {
        echo "<p style='text-align: center; color: red;'>All fields are required!</p>";
    } elseif (!is_numeric($price) || $price <= 0) {
        echo "<p style='text-align: center; color: red;'>Price must be a positive number!</p>";
    } elseif (!ctype_digit($book_copy)) {
        echo "<p style='text-align: center; color: red;'>Book copies must be a non-negative integer!</p>";
    } else {
        // Check if the record exists
        $check_sql = "SELECT * FROM books WHERE isbn = ?";
        $stmt = $conn->prepare($check_sql);

        if (!$stmt) {
            die("<p style='text-align: center; color: red;'>SQL Error: " . $conn->error . "</p>");
        }

        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the record
            $update_sql = "UPDATE books SET book_name = ?, author_name = ?, price = ?, book_copy = ? WHERE isbn = ?";
            $update_stmt = $conn->prepare($update_sql);

            if (!$update_stmt) {
                die("<p style='text-align: center; color: red;'>SQL Error: " . $conn->error . "</p>");
            }

            $update_stmt->bind_param("ssdss", $book_name, $author_name, $price, $book_copy, $isbn);

            if ($update_stmt->execute()) {
                echo "<p style='text-align: center; color: green;'>Book information updated successfully!</p>";
            } else {
                echo "<p style='text-align: center; color: red;'>Error updating book: " . $update_stmt->error . "</p>";
            }

            $update_stmt->close();
        } else {
            echo "<p style='text-align: center; color: red;'>No book found with ISBN: $isbn.</p>";
        }

        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
