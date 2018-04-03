<html>

<?php
    session_start();
    $mid = $_POST["mid"];
    $_SESSION['keyWord'] = $_POST["keyWord"];
    $connection = new mysqli("localhost", "root", "root", "Homework3");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $fetchMembers = "select mid from Member where mid = '$mid'";
    $midComparison = mysqli_query($connection, $fetchMembers);
    if (count(mysqli_fetch_assoc($midComparison)) === 0) {
        echo("fail to read membership information" . "</br>");
        echo("the keyword is : " . $_SESSION['keyWord']);
    } else {
        $_SESSION['mid'] = $mid;
        header("Location: searchResult.php");
        die("Redirecting to: searchResult.php");
    }
?>

</html>