<?php
// Database connection details
$host = 'localhost'; // Replace with your database host
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$dbname = 'booklibrary'; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from book_info table
$sql = "SELECT book_name, author_name, isbn, price, book_copy FROM books";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <img src="IDI.jpg">
    <link rel="stylesheet" href="style.css"/>
    <title>Book library</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COOKIES & SESSION</title>
 
  </head>
  <body>
    <div class="main">



      <div class="left-box"> 
      <h3 style="text-align: center;">Used Tokens List</h3>
    <table>
        <thead>
            <tr>
            </tr>
        </thead>
        <tbody>
        <?php
// Path to the useToken.json file
$useTokenFile = 'useToken.json';
// Function to add a token to useToken.json without duplicates
function saveUniqueToken($token, $useTokenFile) {
    // Check if useToken.json exists and load its content
    $usedTokens = [];
    if (file_exists($useTokenFile)) {
        $usedTokens = json_decode(file_get_contents($useTokenFile), true) ?? [];
    }
    // Check if the token is already in the list
    if (!in_array($token, $usedTokens)) {
        // Add the new token to the list
        $usedTokens[] = $token;
        // Save the updated list back to useToken.json
        file_put_contents($useTokenFile, json_encode($usedTokens, JSON_PRETTY_PRINT));
        echo "<p style='color:green;'>Token {$token} saved successfully!</p>";
    } else {
        echo "<p style='color:orange;'>Token {$token} is already in useToken.json.</p>";
    }
}
if (file_exists($useTokenFile)) {
  $usedTokens = json_decode(file_get_contents($useTokenFile), true);
  // Ensure only unique tokens are shown
  $uniqueTokens = array_unique($usedTokens);
  if (!empty($uniqueTokens)) {
      foreach ($uniqueTokens as $token) {
          echo "<tr><td>" . htmlspecialchars($token) . "</td></tr>";
      }
  } else {
      echo "<tr><td>No tokens have been used yet.</td></tr>";
  }
} else {
  echo "<tr><td>useToken.json file not found.</td></tr>";
}
?>
        </tbody>
    </table>
      </div>
 

      <div class="main-section">
        <section class="top">



          <div class="box1">

          <h1 style="text-align: center;">Update Book Information</h1>
          <br>
    <form method="POST" action="update.php">
        <div>
            <label for="isbn"> <b> ISBN: <b> </label>
            <input type="text" id="isbn" name="isbn" placeholder=" " required>
        </div>
        <div>
            <label for="book_name">Book Name:</label>
            <input type="text" id="book_name" name="book_name" required>
        </div>
        <div>
            <label for="author_name">Author Name:</label>
            <input type="text" id="author_name" name="author_name" required>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>
        </div>
        <div>
            <label for="book_copy">Copies Available: <b> </label>
            <input type="number" id="book_copy" name="book_copy" required>
        </div>
        <br>
        <button type="submit">Update Book</button>
    </form>



          </div>




          <div class="box1">

          <h1 style="text-align: center;">Books Information</h1>
          <br>
    <table>
        <thead>
        <tr> 
    <th>Book Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    <th>Author Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    <th>ISBN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    <th>Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    <th>Copies Available</th>
</tr>

        </thead>
        <tbody>
            <?php
            // Check if there are rows in the result
            if ($result->num_rows > 0) {
                // Loop through each row and display it in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                    echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['book_copy']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no data, show a message
                echo "<tr><td colspan='5'>No books found in the database.</td></tr>";
            }

            // Close the connection
            $conn->close();
            ?>
        </tbody>
    </table>

          </div>
          
          
          
          <div class="box1"> 
          <form 
            action="database.php" method="POST">
            <h1 style="text-align: center;">Insert Book Information</h1>
            <br>
            <label for="book_name"> <b> Book Name: <b> </label>
            <input type="text"  name="book_name" placeholder=" "><br>
            <label for="author_name">Author Name:</label>
            <input type="text"  name="author_name" placeholder=" "><br>
            <label for="ISBN">ISBN:</label>
            <input type="text" name ="isbn" placeholder=" "><br>
            <lable for="Price">Price:</label>
            <input type="text" name="price" placeholder=" "><br>
            <label for="book_copy">Number of Copy:</label>
            <input type="text"  name="book_copy" placeholder=" "><br>
            <br>
            <input type="submit" value="Submit" name="submit"> 
          </form> 
        </div>



        </section>
        <section class="middle">

          <div class="box2"> <img src="book1.JPG"  width="185" height="160">  </div>
          <div class="box2"> <img src="book2.JPG"  width="185" height="160"> </div>
          <div class="box2"> <img src="book3.JPG"  width="185" height="160"> </div>

        </section>
        <section class="lower">
         


        <div class="box3-1">
    <form action="process.php" method="post">
    <h3 style="text-align: center;">Information</h3>
        <b> Student Name: </b> <input type="text" name="name"> <br>
        <b> Student ID: </b> <input type="text" name="ID"> <br>
        <b> Email: </b> <input type="email" name="email"> <br>
        <b> Book Title: </b> <input type="text" name="tittle"> <br>
        <b> Borrow Date: </b> <input type="date" name="date" value=""/> <br>
        <b> Return Date: </b> <input type="date" name="return_date" value=""/> <br>
        <b> Token: </b> <input type="text" name="token"> <br>
        <b> Fees: </b> <input type="text" name="fee"> <br>
  <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
           </form>




          <div class="box3">
          <h3 align ="center">TOKENS</h3>
        <table>
    <?php
    // Read the JSON file
    $jsonFile = 'token.json';
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);
        if (isset($data['tokens']) && is_array($data['tokens'])) {
            foreach ($data['tokens'] as $token) {
                echo "<tr><td>{$token}</td></tr>";
            }
        } else {
            echo "<tr><td>No tokens found</td></tr>";
        }
    } else {
        echo "<tr><td>JSON file not found</td></tr>";
    }
    ?>
</table>
        </div>
        </section>
      </div>



      <div class="right-box"> 
</div>
    </div>

  </body>
</html>