<?php
//create database
if (isset($_POST["submit"])) {
  $book_name=$_POST["book_name"];
  $author_name=$_POST["author_name"];
  $isbn=$_POST["isbn"];
  $price=$_POST["price"];
  $book_copy=$_POST["book_copy"];

                  $conn = mysqli_connect('localhost', 'root', '', 'booklibrary');
                  $sql = "INSERT INTO books(book_name,author_name,isbn,price,book_copy) VALUES('$book_name','$author_name','$isbn','$price','$book_copy')";
                  if (mysqli_query($conn, $sql)) {  
                    echo"inserted";
                  }
                  else{
                    die("failed");
                  }   }

?>
