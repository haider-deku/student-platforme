<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="controle.js"></script>
    <link rel="stylesheet" href="style/etudiant.css">
    <title>home</title>
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
    <div class="popup" id="popup">
        <div class="thearea" id="thearea">
            <form action="etudiant.php" method="POST" enctype="multipart/form-data">
            <h3 align="center">create a post</h3>
            <span class="close-btn" id="closeModalBtn">&times;</span>
            
                <div class="areabody">
                    <textarea name="txt" id="txt" placeholder="what's in your mind"></textarea>
                </div>
                <div class="contentbtn">
                    <label for="fl" class="custom-file-upload">Upload a File</label>
                    <input type="file" id="fl" name="fl">
                    <label for="img" class="custom-file-upload">Upload an Image</label>
                    <input type="file" id="img" name="img" accept="image/*">
                    <select name="l" id="l">
                        <option value="nothing">target level</option>
                        <option value="1">1er anne</option>
                        <option value="2">2eme anee</option>
                        <option value="3">3eme annee</option>
                        <option value="master">master</option>
                        <option value="cycle">cycle ingenieur</option>
                    </select>
                </div>
                <div class="button-container">
                    <button type="submit">Post</button>
                </div>
            
            </form>
        </div>
    </div>
    
        <aside>
        <ul type="none">
            <li><input type="checkbox" class="level-filter" value="1">1er anne</li>
            <li><input type="checkbox" class="level-filter" value="2">2eme anee</li>
            <li><input type="checkbox" class="level-filter" value="3">3eme annee</li>
            <li><input type="checkbox" class="level-filter" value="master">master</li>
            <li><input type="checkbox" class="level-filter" value="cycle">cycle ingenieur</li>
        </ul>
            <br>
            <p>search :</p>
            <input type="search" name="rech" id="rech">
        </aside>
        <section>
            <div class="creepost">
                <button id="lunch_text_area">add a post</button>
            </div>

                <?php
                // Database connection
                $cx = mysqli_connect("localhost", "root", "", "platforme_uni");
                session_start(); // Start the session to access session variables

                // Check if the ID is passed
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                } elseif (isset($_SESSION['user_id'])) {
                    $id = $_SESSION['user_id'];
                } else {
                    echo "<script>alert('User ID is missing.');</script>";
                    exit();
                }

                $filters = [];

                if (isset($_GET['levels'])) {
                    $filters = explode(",", $_GET['levels']);
                }

                $filterSql = "";
                if (!empty($filters)) {
                    $placeholders = "'" . implode("','", $filters) . "'";
                    $filterSql = "WHERE target_class IN ($placeholders)";
                }


                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['txt'])) {
                    $Ncontent = mysqli_real_escape_string($cx, $_POST["txt"]); // Always escape
                    $target = mysqli_real_escape_string($cx, $_POST["l"]);
                    $pdate = date("Y-m-d H:m:s");

                    // Initialize variables
                    $ppic = NULL;
                    $pfile = NULL;

                    // Handle image upload
                    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == 0) {
                        $imgContent = file_get_contents($_FILES["img"]["tmp_name"]);
                        $ppic = mysqli_real_escape_string($cx, $imgContent); // Save as binary
                    }

                    // Handle file upload
                    if (isset($_FILES["fl"]) && $_FILES["fl"]["error"] == 0) {
                        $fileContent = file_get_contents($_FILES["fl"]["tmp_name"]);
                        $pfile = mysqli_real_escape_string($cx, $fileContent); // Save as binary
                    }

                    // Insert post into database
                    $req3 = "INSERT INTO post (target_class, content, pic, file, author_id, dateCreated) 
                            VALUES ('$target', '$Ncontent', " . ($ppic ? "'$ppic'" : "NULL") . ", " . ($pfile ? "'$pfile'" : "NULL") . ", '$id', '$pdate')";
                    $r3 = mysqli_query($cx, $req3) or die(mysqli_error($cx));

                    // Redirect after successful insertion
                    if (mysqli_affected_rows($cx) > 0) {
                        header('Location: etudiant.php');
                        exit();
                    } else {
                        echo "<script>alert('Publication échouée !');</script>";
                    }
                }
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['report'])) {
                    $reportedPostId = mysqli_real_escape_string($cx, $_POST['report_post_id']);
                    $userId = $id;
                
                    $check = "SELECT * FROM pubsignal WHERE post_id = '$reportedPostId' AND user_id = '$userId'";
                    $res = mysqli_query($cx, $check);
                
                    if (mysqli_num_rows($res) == 0) {
                        $insert = "INSERT INTO pubsignal (post_id, user_id, nb_signalement) VALUES ('$reportedPostId', '$userId', 1)";
                        mysqli_query($cx, $insert) or die(mysqli_error($cx));
                        $_SESSION['report_status'] = 'success';
                    } else {
                        $_SESSION['report_status'] = 'already';
                    }
                
                    // Prevent form resubmission
                    header("Location: etudiant.php");
                    exit();
                }
                
                // Show alert only after redirect
                if (isset($_SESSION['report_status'])) {
                    if ($_SESSION['report_status'] === 'success') {
                        echo "<script>alert('Post reported successfully.');</script>";
                    } elseif ($_SESSION['report_status'] === 'already') {
                        echo "<script>alert('You already reported this post.');</script>";
                    }
                    unset($_SESSION['report_status']);
                }
                
                

                    // Fetch posts
                    $req1 = "SELECT * FROM post $filterSql";
                    $r1 = mysqli_query($cx, $req1) or die(mysqli_error($cx));

                    // Display posts
                    if (mysqli_num_rows($r1) == 0) {
                        echo '<div class="no-posts"> Aucun post disponible pour les niveaux sélectionnés.</div>';
                    }
                     else {
                        while ($row = mysqli_fetch_array($r1)) {
                            $post_id = $row['post_id'];
                            $desc = $row['content'];
                            $picData = $row['pic'];
                            $fileData = $row['file'];
                            $author_id = $row['author_id'];
                            $date = $row['dateCreated'];

                            // Get student name
                            $req2 = "SELECT * FROM student WHERE user_id = '$author_id'";
                            $r2 = mysqli_query($cx, $req2) or die(mysqli_error($cx));
                            if ($row2 = mysqli_fetch_assoc($r2)) {
                                $studentName = $row2['name'];
                                $pic = $row2['user_pic'];
                            } else {
                                $studentName = 'Unknown';
                                $pic = NULL;
                            }

                    ?>
                            <div class="post">
                                <?php if (!empty($pic)): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($pic); ?>" class="upic" alt="user pic">
                                <?php else: ?>
                                <img src="user pic.png" class="upic" alt="user pic">
                                <?php endif; ?>
                                <p class="username"><?php echo htmlspecialchars($studentName); ?></p>
                                
                                <div class="contenue">
                                    <p class="post-content"><?php echo nl2br(htmlspecialchars($desc)); ?></p>
                                    <form method="POST" action="etudiant.php" class="report-form">
                                    <input type="hidden" name="report_post_id" value="<?php echo $post_id; ?>">
                                    <button type="submit" name="report" class="report-btn"> Report</button>
                                </form>
                                    <div class="pic">
                                        <?php if (!empty($picData)): ?>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($picData); ?>" class="cpic" >
                                        <?php endif; ?>
                                        <?php if (!empty($fileData)): ?>
                                            <embed src="data:application/pdf;base64,<?php echo base64_encode($fileData); ?>" width="100%" height="500px" type="application/pdf">
                                            <br>
                                            <a href="data:application/pdf;base64,<?php echo base64_encode($fileData); ?>" download="file.pdf">Download PDF</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>
        </section>
        
    </main>
    <script src="controle.js"></script>
</body>
</html>
