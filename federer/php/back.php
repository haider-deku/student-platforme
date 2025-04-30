<?php
// Retrieve form data
$ad = $_POST['ad'];
$nom = $_POST['nom'];
$pwd = $_POST['pwd'];
$niv = $_POST['l'];
$today = date("Y-m-d");
// Connect to database
$cx = mysqli_connect("localhost", "root", "", "platforme_uni");
// Check if email already exists
$req1 = "SELECT * FROM student WHERE email='$ad'";
$r1 = mysqli_query($cx, $req1) or die(mysqli_error($cx));

if (mysqli_num_rows($r1) == 0) {
    $req2 = "INSERT INTO student (name,email,pwd,created_at,class) VALUES ('$nom', '$ad', '$pwd', '$today', '$niv')";
    $r2 = mysqli_query($cx, $req2) or die(mysqli_error($cx));
    if (mysqli_affected_rows($cx)>0) {
        echo "Inscription effectuée ";
        echo"<br> <a href='login.html'>go to login page</a>";
    } else {
        echo "Inscription échouée";
    }
} else {
    echo "Email déjà utilisé";
    echo"<br> <a href='sign_in.html'>sign in again</a>";
}
mysqli_close($cx);
?>
