<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="controle.js"></script>
    <link rel="stylesheet" href="style\login.css">
    <title>login</title>
</head>
<body>
    <?php
        session_start();

        // Connect to database
        $cx = mysqli_connect("localhost", "root", "", "platforme_uni");

        if ($_POST) {
            $ad = $_POST['ad'];
            $pwd = $_POST['pwd'];

            // Check if admin
            $req1 = "SELECT * FROM admin WHERE email='$ad' and password='$pwd'";
            $r1 = mysqli_query($cx, $req1) or die(mysqli_error($cx));

            if (mysqli_num_rows($r1) == 1) {
                header('Location: admin.php');
                exit(); // Always good after header redirection
            } else {
                // Check if student
                $req2 = "SELECT * FROM student WHERE email='$ad' and Pwd='$pwd'";
                $r2 = mysqli_query($cx, $req2) or die(mysqli_error($cx));

                if (mysqli_num_rows($r2) == 1) {
                    $row = mysqli_fetch_assoc($r2);
                    $id = $row['user_id']; 
                    $_SESSION['user_id'] = $id;
                    header('Location: etudiant.php?id=' . $id);
                    exit();
                } else {
                    // If neither admin nor student
                    echo "<script>
                            alert('Login failed!');
                            window.location.href = 'login.php';
                        </script>";
                }
            }
        }
        mysqli_close($cx);
    ?>


    <header>
        <h1>Student platforme</h1>
    </header>
    <main class="main">
        <section >
        <fieldset>
        <legend><b>Login</b></legend>
        <form action="login.php" method="post" onsubmit="return verif();">
            <table>
                <tr>
                    <td><label for="ad">Adresse universitaire :</label></td>
                </tr>
                <tr>
                    <td><input type="text" name="ad" id="ad" placeholder="nomprenom@isitcom.rnu.tn"></td>
                </tr>
                <tr>
                    <td><span id="error1"></span></td>
                </tr>
                <tr>
                    <td><label for="pdw">Mot de passe :</label></td>
                </tr>
                <tr>
                    <td><input type="password" name="pwd" id="pwd" placeholder="8 caractere"></td>
                </tr>
                <tr>
                    <td><span id="error2"></span></td>
                </tr>
                <tr>
                    <td >
                        <input type="submit" value="login" id="btn" >
                    </td>
                </tr>
            </table>
            
        </form>
    </fieldset>
    </section>
    </main>
    <footer>
        <b> © 2025 All Rights Reserved Terms of 2LM2</b>
    </footer>
</body>
</html>