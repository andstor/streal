<?php

require 'config/config.php';
require 'connections/Database.php';
require 'helpers/helper.php';

$db = new Database();


// Saves the results for later when it's going to be used in the menu
$categoryResults = $db->select("SELECT * FROM category");

// Checks if an article is getting published
if (isset($_POST['post'])) {

    // Removes the published article link
    if (isset($_SESSION['link'])) {
        unset($_SESSION['link']);
    }

    // Saves the super globals to easily readable variables
    $title = $_POST['title'];
    $img = $_POST['img'];
    $caption = $_POST['caption'];
    $cat = $_POST['cat_id'];
    $text = $_POST['text'];

    // Checks if the required fields aren't empty and cleans user input
    if (isset($title) && isset($img) && isset($cat) && isset($text)) {
        $title = preg_replace('/[^A-Za-z0-9 æ\ø\å\Æ\Ø\Å\-\&]/', '', (substr($db->link->real_escape_string($title), 0, 64)));
        $img = htmlspecialchars(substr($db->link->real_escape_string($img), 0, 255), ENT_NOQUOTES);
        $caption = htmlspecialchars(substr($db->link->real_escape_string($caption), 0, 255), ENT_NOQUOTES);
        $cat = substr($db->link->real_escape_string($cat), 0, 5);
        $text = htmlentities($db->link->real_escape_string($text));

        // Checks if category id written by user is a number
        if (is_numeric($cat)) {
            $sql = "SELECT id FROM category WHERE id = $cat LIMIT 1";
            $result = $db->select($sql);

            // Checks if category id written by user exists (change)
            if ($result->num_rows == 1) {
                $img_header = @get_headers($img, 1);

                // Checks if image link provided by user exists
                if (strpos($img_header[0], '404') === false) {

                    // Checks if referenced file is an image
                    if (strpos(str_replace("/", " ", $img_header['Content-Type']), 'image') !== false) {
                        $time = date('Y-m-d H:m:s');
                        $sql = "INSERT INTO article (title, caption, category_id, cover, text, published) 
								VALUES ('$title', '$caption', $cat, '$img', '$text', '$time')";
                        $result = $db->link->query($sql);

                        // Checks if article is published
                        //	if (isset($result)) {
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
                        /*	}
                            else {
                                alert('Couldn\'t post the article.');
                            }*/
                    } else {
                        alert('The file isn\'t an image.');
                    }
                } else {
                    alert('Image doesn\'t exist.');
                }
            } else {
                alert('Category id doesn\'t exist.');
            }
        } else {
            alert('Category id must be a number.');
        }
    } else {
        alert('Fill out all the fields.');
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
        <form action='' method='POST' class='publish'>
            <fieldset>
                <legend>Create an article</legend>
                <input type='text' name='title' placeholder='Title'><br>
                <input type='text' name='img' placeholder='Ex: http://link/to/image.jpg'><br>
                <input type='text' name='caption' placeholder='Image caption'><br>
                <select name='cat_id'>
                    <?php
                    //Lists all categories from database into the dropdown menu
                    while ($row = $categoryResults->fetch_array(MYSQLI_ASSOC)) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
                <br><br>
                <br>
                <label>Article text</label><br>
                <textarea name='text'></textarea><br>
                <input type='submit' value='Publish' name='post'>
                <?php if (isset($_SESSION['link'])) {
                    echo $_SESSION['link'];
                } ?>
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