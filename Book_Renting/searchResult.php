

<?php
    session_start();
    $mid = $_SESSION['mid'];
    $keyWord = $_SESSION['keyWord'];
    
    $connection = new mysqli("localhost", "root", "root", "Homework3");
    
    $fetchMemberName = "select mname from Member where mid = '$mid'";
    $memberName = mysqli_query($connection, $fetchMemberName);
    
    print("welcome " . mysqli_fetch_assoc($memberName)["mname"] . " !");
    print("</br>");
    print("Books related to " . $_SESSION['keyWord'] . " are :");
    print("</br>");
    print("</br>");
   
    
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    
    $fetchBookContainsKeyWord = "select * from Book where category = '$keyWord' or booktitle = '$keyWord'";
    $fetchAllBooks = "select * from Book";
    $result = mysqli_query($connection, $fetchBookContainsKeyWord);
    
    if (count(mysqli_fetch_assoc($result)) === 0) {
        $result = mysqli_query($connection, $fetchAllBooks);
    }  else {
        $result = mysqli_query($connection, $fetchBookContainsKeyWord);
    }
  
    
   
?>
<html>
<body>
    
    <?php
        $countRow = 0;
        echo'<form action="checkAvailability.php" method="post">';
        while($row = mysqli_fetch_assoc($result)) {
            $countRow = $countRow + 1;
            $bookId = $row["bookid"];
            echo $countRow;
            ?>
    <input type="checkbox" name="checkbox[]" value= "<?php echo $bookId ?>">
            <?php echo  "Book id is: " . $bookId . " booktitle: " . $row["booktitle"] . ", " . " category: " . $row["category"] . ",". " author: " . $row["author"] . "," . "publish date: " . $row["publishdate"] . '</br>' . '</br>';    
        }
        $_SESSION["numberOfBooks"] = $countRow;
        echo '<input type="submit" value="Check out">' . '</form>';
    ?>
    
    
    

</body>   
</html>

