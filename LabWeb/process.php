<?php

// Name Validation
if (!preg_match("/^[A-Za-z ]*$/", $_POST["name"])) {
    echo "Give Only Character in Name" . "<br>";
    $error[] = "Give character";
}

// ID Validation 
if (!preg_match("/^[0-9]{2}-[0-9]{5}-[0-9]{1}$/", $_POST["ID"])) {
    echo "Provide xx-yyyyy-z format in Student ID" . "<br>";
    $error[] = "Give right format";
}

// Email Validation
if (!preg_match("/\@+(student)+\.(aiub)+\.(edu)/", $_POST['email'])) {
    echo "Email must be in the format: Local-part@student.aiub.edu <br>" . "<br>";
    $error[] = "Provide right format";
}

// Validate Book Title
if (preg_match("/^[A-Za-z]/", $_POST["tittle"])) {
}
     else {
    echo "Book Title is required <br>";
    $error[] = "Book Title is required";
}

// Validate Borrow Date and Return Date
$borrowDate = $_POST['date'];
$returnDate = $_POST['return_date'];

if (empty($borrowDate)) {
    echo "Insert Borrow Date. <br>";
    $error[] = "Borrow Date is required.";
}

if (empty($returnDate)) {
    echo "Insert Return Date. <br>";
    $error[] = "Return Date is required.";
}

if (!empty($borrowDate) && !empty($returnDate)) {
    if (strtotime($returnDate) < strtotime($borrowDate)) {
        echo "Return Date cannot be before Borrow Date. <br>";
        $error[] = "Return Date cannot be before Borrow Date.";
    }
    if ((strtotime($returnDate) - strtotime($borrowDate)) < 864000) {
        echo "Return Date must be at least 10 days after Borrow Date. <br>";
        $error[] = "Return Date must be at least 10 days after Borrow Date.";
    }
}

// Token Validation
$jsonFile = 'token.json';
$useTokenFile = 'useToken.json';
if (preg_match("/^[0-9]+$/", $_POST["token"])) {
    $inputToken = $_POST["token"];
    
    if (file_exists($jsonFile)) {
        // Read token.json
        $validTokens = json_decode(file_get_contents($jsonFile), true)['tokens'] ?? [];
        if (in_array($inputToken, $validTokens)) {
            // Check useToken.json
            $usedTokens = file_exists($useTokenFile) ? json_decode(file_get_contents($useTokenFile), true) : [];
            
            if (in_array($inputToken, $usedTokens)) {
                echo "<p style='color:red;'>Token {$inputToken} has already been used.</p>";
                $error[] = "Token already used.";
            } else {
                // Save the new token to useToken.json
                $usedTokens[] = $inputToken;
                file_put_contents($useTokenFile, json_encode($usedTokens, JSON_PRETTY_PRINT));
                echo "<p style='color:green;'>Token {$inputToken} validated and saved successfully!</p>";
            }
        } else {
            echo "<p style='color:red;'>Token {$inputToken} not found in the valid token list.</p>";
            $error[] = "Invalid token.";
        }
    } else {
        echo "<p style='color:red;'>token.json file not found.</p>";
        $error[] = "Token validation failed.";
    }
} else {
    echo "Provide a numeric token.<br>";
    $error[] = "Invalid token format.";
}

$jsonFile = 'token.json';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputToken = $_POST['token']; // Get the token from the form input

    // Check if token.json exists and read tokens
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);

        if (isset($data['tokens']) && is_array($data['tokens'])) {
            // Check if input token matches a token in the list
     if (in_array($inputToken, $data['tokens'])) {
                // Save the matched token to useToken.json
                $useTokenFile = 'useToken.json';
                $usedTokens = [];
                // Read existing used tokens if the file exists
                $usejsonFile = 'useToken.json';
                if (file_exists($useTokenFile)) {
                    $usedTokens = json_decode(file_get_contents($useTokenFile), true);
                }
                // Add the new token
                $usedTokens[] = $inputToken;
                // Save back to useToken.json
                file_put_contents($useTokenFile, json_encode($usedTokens, JSON_PRETTY_PRINT));
                echo "Saved successfully." . "<br><br>";
            } else {
                echo "Token not found in the token list.";
            }
        } else {
            //echo "<p style='color:red; text-align:center;'>Token list is empty.</p>";
        }
    } else {
       // echo "<p style='color:red; text-align:center;'>token.json file not found.</p>";
    }
}

// Fees Validation
if (!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $_POST["fee"])) {
    echo "Enter Accurate Fees of Books" . "<br>";
    $error[] = "Provide valid number";
}

// Cookie Handling
$tittle = $_POST['tittle'];
$cookie_name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $tittle); 
$cookie_value = $_POST['name'];

if (empty($error)) {
    if (isset($_COOKIE[$cookie_name])) {
        echo "The Book is Already Borrowed. ";
    } else {
    
        setcookie($cookie_name, $cookie_value, time() + (15), "/"); // 15 seconds
        echo "RECIEPT". "<br><br>";
        echo "Student Name:". $_POST['name']."<br>";
        echo "Student ID:".$_POST['ID']."<br>";
        echo "Email:".$_POST['email']."<br>";
        echo "Book Tittle:".$_POST['tittle']."<br>";
        echo "Borrow Date:".$_POST['date']."<br>";
        echo "Return Date:".$_POST['return_date']."<br>";
        echo "Token: ".$_POST['token']."<br>";
        echo "Fees:". $_POST['fee']."<br>";
    }
}

?>


