<?php
    session_start();
    $connection = new mysqli("localhost", "root", "root", "Homework3");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $checkedArray = $_POST['checkbox'];
    $numberOfRows = count($checkedArray);
    $index = 0;
    echo '<form action="checkOutResult.php" method="post">';
    while($index < $numberOfRows) {
        $bookId = $checkedArray[$index];
        $copyIdSQL = "select copyid from BookCopy where bookid = '$bookId'";
        $fetchCopy = mysqli_query($connection, $copyIdSQL);
        if (count(mysqli_fetch_assoc($fetchCopy)) === 0) {
            echo $bookId . " not available </br>";
        } else {
            $fetchCopy = mysqli_query($connection, $copyIdSQL);
            while($row = mysqli_fetch_assoc($fetchCopy)) {
                $copyId = $row["copyid"];
                $statusSQL = "select status from CheckedOut where copyid = '$copyId'";
                $fetchStatus = mysqli_query($connection, $statusSQL);
                $isHeld = false;
                while ($status = mysqli_fetch_assoc($fetchStatus)) {
                    if ($status["status"] === "Holding" || $status["status"] === "Overdue") {
                        $isHeld = true;
                    }
                }
                if (!$isHeld) {
                    echo $bookId . " " . $copyId . " available."; ?>
                    <input type = "checkbox" name="copyCheckbox[]" value="<?php echo $copyId ?>">
                    <?php
                    echo "</br>";
                } else {
                    echo $bookId . " " . $copyId . " Not available" . "</br>";
                }
                
            }
        }
        $index = $index + 1;
    }
    echo '<input type="submit" value="Continue">' . '</form>';
?>

