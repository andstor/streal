<?php
	require 'config/config.php';
	require 'connections/Database.php';

	$db = new Database();

	if (isset($_GET['post']) && is_numeric($_GET['post'])) {
		$articleID = substr($_GET['post'], 0, 5);
	}
	else {
		header('HTTP/1.0 404 Not Found');
		exit;
	}

	$sql = "SELECT * FROM article WHERE id = $articleID LIMIT 1";
	$row = $db->select($sql)->fetch_assoc();
	$db->link->close();

	if (empty($row)) {
		header('HTTP/1.0 404 Not Found');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Streal</title>
    <link rel="stylesheet" href="styles/article.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <script type="text/javascript" src="scripts/main.js"></script>
</head>

<body>

<?php include_once 'includes/navbar.php' ?>


<main class="wrapper">
    <section class="grid-article">
        <figure class="articlePageMainFigure">
            <img src=<?php echo $row['cover'] ?> class="articlePageMainImage">
            <figcaption><?php echo $row['caption'] ?></figcaption>
        </figure>
        <h1 class="articlePageHeader"><?php echo $row['title'] ?></h1>
        <p><?php echo html_entity_decode($row['text']) ?></p>
    </section>
</main>
<?php include_once 'includes/footer.php' ?>

</body>