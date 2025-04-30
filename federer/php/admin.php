<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="controle.js"></script>
    <link rel="stylesheet" href="style/admin.css">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
    <div class="logo">
        <h1><i class="fa-solid fa-book-open-reader">      doc-share</i> </h1>
    </div>
        <a href="login.php"><button type="button" id="logout">Log Out</button></a>
    </header>
    <main id="main_etudiant">
        <aside class="accarea">
            <h2>account managment</h2>
            <?php
            $cx = mysqli_connect("localhost", "root", "", "platforme_uni");
            $req = "SELECT * FROM student";
            $r = mysqli_query($cx, $req) or die(mysqli_error($cx));

            if (mysqli_num_rows($r) == 0) {
                echo "Aucun compte disponible";
            } else {
                while ($row = mysqli_fetch_array($r)) {
                    $pic = $row['user_pic'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $class = $row['class'];
                    ?>
                    <div class="acc">
                        <?php if (!empty($pic)): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($pic); ?>" class="upic" alt="user pic">
                        <?php else: ?>
                            <img src="user pic.png" class="upic" alt="user pic">
                        <?php endif; ?>
                        
                        <p class="username"><?php echo htmlspecialchars($name); ?></p>
                        <p><?php echo htmlspecialchars($class); ?></p>
                        <p class="username"><?php echo htmlspecialchars($email); ?></p>
                        <div class="btnContainer">
                            <button class="rep">report account</button>
                            <button class="del">delete account</button>
                            <button class="act">active account</button>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </aside>

        <section>
            <h1>reported posts</h1>
            <?php
            $req1 = "SELECT * FROM pubsignal";
            $r1 = mysqli_query($cx, $req1) or die(mysqli_error($cx));

            if (mysqli_num_rows($r1) == 0) {
                echo "<p>Aucun post signalé disponible</p>";
            } else {
                echo '<div class="posts-wrapper">';
                while ($signalRow = mysqli_fetch_array($r1)) {
                    $user_id = $signalRow['user_id'];
                    $post_id = $signalRow['post_id'];

                    $postQuery = "SELECT * FROM post WHERE post_id = '$post_id'";
                    $postResult = mysqli_query($cx, $postQuery);
                    $postRow = mysqli_fetch_assoc($postResult);
                    if (!$postRow) continue;

                    $author_id=$postRow['author_id'];
                    $desc = $postRow['content'];
                    $picData = $postRow['pic'];
                    $fileData = $postRow['file'];

                    $nameQuery = "SELECT name FROM student WHERE user_id = '$author_id'";
                    $nameResult = mysqli_query($cx, $nameQuery);
                    $studentName = (mysqli_num_rows($nameResult) > 0) ? mysqli_fetch_assoc($nameResult)['name'] : 'Unknown';
                    ?>
                    <div class="postContainer">
    <div class="post">
        <p class="username"><?php echo htmlspecialchars($studentName); ?></p>
        
        <div class="contenue">
            <p><?php echo nl2br(htmlspecialchars($desc)); ?></p>
        </div>

        <div class="pic">
            <?php if (!empty($picData)): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($picData); ?>" class="cpic">
            <?php endif; ?>

            <?php if (!empty($fileData)): ?>
                <embed src="data:application/pdf;base64,<?php echo base64_encode($fileData); ?>" width="100%" height="500px" type="application/pdf">
                <br>
                <a href="data:application/pdf;base64,<?php echo base64_encode($fileData); ?>" download="file.pdf">Download PDF</a>
            <?php endif; ?>
        </div>

        <!-- DELETE BUTTON clearly OUTSIDE file/pdf zone -->
        <div class="post-actions">
            <form method="POST" action="etudiant.php" class="delete-post-form">
                <input type="hidden" name="delete_post_id" value="<?php echo $post_id; ?>">
                <button type="submit" name="delete_post" class="delete-btn"> Delete Post</button>
            </form>
        </div>
    </div>
</div>

                    <?php
                }
                echo '</div>';
            }
            ?>
        </section>
    </main>
    <script src="controle.js"></script>
</body>
</html>
