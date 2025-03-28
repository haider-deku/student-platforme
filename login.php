<?php
// Retrieve form data
$ad = $_POST['ad'];
$pwd = $_POST['pwd'];
// Connect to database
$cx = mysqli_connect("localhost", "root", "", "platforme_uni");
// Check if email already exists
$req1 = "SELECT * FROM student WHERE email='$ad' and pwd='$pwd'";
$r1 = mysqli_query($cx, $req1) or die(mysqli_error($cx));

if (mysqli_num_rows($r1) == 0) {
    echo "connexion echoue";
    echo"<br> <a href='login.html'>log in again</a>";
} else {
    echo"<br> <a href='home.html'>home page</a>";
}

// Close database connection
mysqli_close($cx);
?>
