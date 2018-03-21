<?php include 'config/config.php'; ?>
<?php include 'connections/Database.php'; ?>
<?php include 'helpers/format_helper.php'; ?>


<?php
// Create DB object
$db = new Database;

$query = "SELECT * FROM category";

function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}

// Run query
$category = $db->select($query);
if ((isset($_GET['submit']) && $_GET['q'] != null) && (isset($_GET['device']) || isset($_GET['price']) || isset($_GET['rating']) || isset($_GET['q']))) {
// Create query

    $lol = array("SELECT * FROM article WHERE");

    // Checks if user has chosen a device
    if (isset($_GET['device']) && $_GET['device'] != "") {
        $device = $_GET['device'];
        array_push($lol, " AND device = '$device'");
    }

    // Checks if user has written in search bad
    if (isset($_GET['q']) && $_GET['q'] != "" && $_GET['q'] != null && !empty($_GET['q'])) {
        $q = $_GET['q'];
        array_push($lol, " AND title = '$q'");
    }

    $query = implode($lol);

    $query = str_replace_first("AND", "", $query);

} else {
    $query = "SELECT * FROM article";
}

$article = $db->select($query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Streal</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/index.css">
    <script type="text/javascript" src="scripts/main.js"></script>
</head>
<body>

<div class="navbar-background" id="navbar-container">
    <nav class="navbar wrapper" id="navbar">
        <h1 style="color:white" class="grid-logo logoHeader">Logo</h1>
        <ul class="grid-menu">
            <li><a href="#" id="hamburgerIcon">&#9776;</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </nav>
</div>

<main class="wrapper">

    <section class="category grid-category">
        <!-- Button for searching -->
        <!--<button class="categorieButton" type="button" name="button">
            Search
        </button>-->
        <!-- Searchbar -->
        <form class="grid-searchbar" action="" method="GET">
                    <div class="selectors grid-selectors">
            <!-- Selectors -->
            <label>Device:</label>
            <select name="device">
                <option value="" selected></option>
                <?php if ($category) : ?>
                    <?php while ($row = $category->fetch_assoc()) : ?>
                        <option value="<?php echo $row['name']; ?>">
                            <?php echo $row['name']; ?>
                        </option>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No categories yet</p>
                <?php endif; ?>
            </select>
        </div>
            <input class="categorieButton" type="submit" value="Submit" name="submit">
            <input class="searchbar" type="text" name="q" placeholder="Search..">
        </form>
    </section>

    <section class="articles grid-sectionArticles">
        <!-- Template of an article -->
        <?php if ($article) : ?>
            <?php while ($row = $article->fetch_assoc()) : ?>
                <article class="indexArticle ">
                    <a href="article.php?post=<?php echo $row['id']; ?>">
                        <!-- image side -->
                        <aside class="indexAside grid-firstHalf">
                            <img class="articleImg" src="<?php echo $row['cover']?>" alt="placeholder">
                        </aside>
                        <!-- Description -->
                        <div class="grid-secondHalf article-text" id="overskrift">
                            <h1 class="articleHeader"><a href="article.php?post=<?php echo $row['id']; ?>">Header</a></h1>
                            <h4>
                                <?php echo shortenText($row['text']); ?>
                            </h4>
                            <h4 class="byline">
                                <small>written by <?php echo $row['author']; ?>
                                    | <?php echo formatDate($row['published']); ?></small>
                            </h4>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>There are no posts yet</p>
        <?php endif; ?>
        <!-- End of template -->
    </section>
    <!-- Featured Section -->
    <section class="grid-sectionFeatured">

    </section>

</main>

<footer class="page-footer">
<div class="wrapper">
    <div class="footer-content">
        <h5>Footer Content</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab debitis dicta explicabo fugit illum impedit
            laboriosam neque odit provident quae quasi.
            content.</p>
    </div>

    <div class="footer-links">
        <h5>Links</h5>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/index.php">Blog</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/post.php">Admin</a></li>
        </ul>
    </div>
</div>

    <div class="footer-copyright-background">
        <div class="wrapper">
            <span class="footer-copyright">© 2014 Copyright Text</span>
        </div>
    </div>
</footer>

</body>
</html