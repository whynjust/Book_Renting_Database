<?php
    session_start();
    $connection = new mysqli("localhost", "root", "root", "Homework3");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $mid = $_SESSION['mid'];
    $checkedArray = $_POST['copyCheckbox'];
    $numberOfRows = count($checkedArray);
    $index = 0;
    while($index < $numberOfRows) {
        $checkOutCopyId = $checkedArray[$index];
        $updateSQL = "insert into CheckedOut (copyid, mid, checkoutDate, dueDate, status) values ('$checkOutCopyId','$mid', NOW(), DATE_ADD(NOW(), INTERVAL 3 MONTH), 'Holding')";
        mysqli_query($connection, $updateSQL);
        $index = $index + 1;
    }
    $resultSQL = "select copyid from CheckedOut where mid = '$mid'";
    $fetchResult = mysqli_query($connection, $resultSQL);
    echo "The books currently checked out by you are: </br>";
    while($row = mysqli_fetch_assoc($fetchResult)) {
        $copyId = $row['copyid'];
        $bookTitleSQL = "select booktitle from Book b join BookCopy bc where bc.copyid = '$copyId' and bc.bookid = b.bookid";
        $bookResult = mysqli_query($connection, $bookTitleSQL);
        
        echo  mysqli_fetch_assoc($bookResult)['booktitle'] . " " .$copyId . "</br>";
    }


