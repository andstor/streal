<?php

require 'config/config.php';
require 'connections/Database.php';
require 'helpers/helper.php';

$db = new Database();

// Saves the results for later when it's going to be used in the menu
$categoryResults = $db->select("SELECT * FROM category");

// Checks if an article is getting published
if (isset($_POST['post'])) {

    // Removes the published article link if set
    if (isset($_SESSION['link'])) {
        unset($_SESSION['link']);
    }

    // Saves the super globals to easily readable variables
    $title = $_POST['title'];
    $caption = $_POST['caption'];
    $author = $_POST['author'];
    $cat = $_POST['cat_id'];
    $text = $_POST['text'];

    // Checks if the required fields aren't empty and cleans user input
    if ($title !== "" && isset($cat) && $text !== "" && $_FILES['upload']['name'] !== "" && $author !== "") {
        $title = preg_replace('/[^A-Za-z0-9 æ\ø\å\Æ\Ø\Å\-\&]/', '', (substr($db->link->real_escape_string($title), 0, 64)));
        $caption = htmlspecialchars(substr($db->link->real_escape_string($caption), 0, 255), ENT_NOQUOTES);
        $author = substr($db->link->real_escape_string($author), 0, 255);
        $cat = substr($db->link->real_escape_string($cat), 0, 5);
        $text = htmlentities($db->link->real_escape_string($text));

        // Checks if category id written by user is a number
        if (is_numeric($cat)) {
            $sql = "SELECT id FROM category WHERE id = $cat LIMIT 1";
            $result = $db->select($sql);

            // Checks if category id written by user exists (change)
            if ($result->num_rows == 1) {
                // Prepares and uploads picture
                $fileUploaded = false;
                $siteURL = $_SERVER['SERVER_NAME'] . '/'; //root directory
                $fileTempLocation = $_FILES["upload"]["tmp_name"];
                $fileExtention = strtolower(pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION)); //file extention
                $fileName = md5(time() . $_FILES["upload"]["name"]) . '.' . $fileExtention; // (almost) unique file name
                $fileFullLocalLink = LOCAL_DIR . UPLOAD_DIR . $fileName;
                $fileFullPublicLink = 'http://' . $siteURL . UPLOAD_DIR . $fileName;
                move_uploaded_file($fileTempLocation, $fileFullLocalLink);

                $fileUploaded = true;

                $img = $fileFullPublicLink;

                // Checks if image link provided by user exists
                if ($fileUploaded) {
                    $time = date('Y-m-d H:m:s');
                    $sql = "INSERT INTO article (title, caption, category_id, cover, text, published, author) 
							VALUES ('$title', '$caption', $cat, '$img', '$text', '$time', '$author')";
                    $result = $db->link->query($sql);

                    $sql = "SELECT id, title, published FROM article WHERE title = '$title' AND published = '$time' LIMIT 1";
                    $result = $db->select($sql);

                    // Confirms that aricle exists within the database
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $articleID = $row['id'];
                        $_SESSION['link'] = '<a href=\'../article.php?post=' . $articleID . '\'>Link to article >>></a>';
                    } else {
                        alert('Something went wrong...');
                    }
                } else {
                    alert('Couldn\'t upload cover image.');
                }
            } else {
                alert('Category id doesn\'t exist.');
            }
        } else {
            alert('Category id must be a number.');
        }
    } else {
        alert('Fill out all the fields and upload an image.');
    }

    if (isset($result)) {
        $result->free_result();
    }

    $db->link->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Streal - Publish </title>
    <meta charset='utf8'>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/publish.css">
    <link rel="stylesheet" href="styles/navbar.css">
</head>

<body>
<?php include_once 'includes/navbar.php' ?>

<main class='wrapper'>
    <section class="grid-publish">
        <br>
        <form action='' method='POST' class='publish' enctype="multipart/form-data">
            <fieldset>
                <legend>Create an article</legend>
                <input type='text' name='title' placeholder='Title'><br>
                <input type='text' name='caption' placeholder='Image caption'><br>
                <input type='text' name='author' placeholder='Author'><br>
                <select name='cat_id'>
                    <?php
                    //Lists all categories from database into the dropdown menu
                    while ($row = $categoryResults->fetch_array(MYSQLI_ASSOC)) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    } $categoryResults->free_result(); ?>
                </select><br><br>
                <input type="file" name="upload"><br><br>
                <label>Article text</label><br>
                <textarea name='text'></textarea><br>
                <input type='submit' value='Publish' name='post'>
                <?php if (isset($_SESSION['link'])) echo $_SESSION['link']; ?>
            </fieldset>
        </form>

        <br><br>
        <p>You are allowed to use html tags inside the text box. Please don't do anything stupid. Remember, Jesus is
            watching.</p>
    </section>
</main>
<?php include_once 'includes/footer.php' ?>

</body>
</html>