<?php

	require 'config/config.php';
	require 'connections/Database.php';
require 'helpers/helper.php'

	$db = new Database();



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
			$title = preg_replace('/[^A-Za-z0-9 æ\ø\å\Æ\Ø\Å\-\&]/','',(substr($db->link->real_escape_string($title), 0, 64)));
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
								}
								else {
									alert('Something went wrong...');
								}
						/*	}
							else {
								alert('Couldn\'t post the article.');
							}*/
						}
						else {
							alert('The file isn\'t an image.');
						}
					}
					else {
						alert('Image doesn\'t exist.');
					}
				}
				else {
					alert('Category id doesn\'t exist.');
				}
			}
			else {
				alert('Category id must be a number.');
			}
		}
		else {
			alert('Fill out all the fields.');
		}
		$db->link->close();
	}

?>

<html>
	<head>
		<title> Streal - Publish </title>
		<meta charset='utf8'>

		<style>

			main {
				width: 50vw;
				height: 50vh;
				margin: 0 auto;
			}

			form.publish {
				display: block;
			}

			form.publish > fieldset > input:not(:last-child)) {
				margin: 0 0 10px 0;
				border-radius: 2px;
			}

			form.publish > fieldset > input:last-child) {
				display: inline-block;

			}

			form.publish > fieldset > textarea {
				width: 100%;
				height: 30vh;
				margin: 0 0 10px 0;
			}

			a {
				color: blue;
				text-decoration: none;
				float: right;
				display: inline-block;
			}

		</style>
	</head>

	<body>
		<main class='container'>
			<form action='#' method='POST' class='publish'>
				<fieldset>
					<legend>Create an article</legend>
					<input type='text' name='title' placeholder='Title'><br>
					<input type='text' name='img' placeholder='Ex: http://link/to/image.jpg'><br>
					<input type='text' name='caption' placeholder='Image caption'><br>
					<input type='number' name='cat_id' placeholder='Category Id'><br> <!-- CHANGE ME -->
					<label>Article text</label><br>
					<textarea name='text'></textarea><br>
					<input type='submit' value='Publish' name='post'>
					<?php if (isset($_SESSION['link'])) { echo $_SESSION['link'];} ?>
				</fieldset>
			</form>

			<section>
				<p>You are allowed to use html tags inside the text box. Please don't do anything stupid. Remember, Jesus is watching.</p>
			</section>
		</main>
	</body>
</html>