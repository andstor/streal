<?php include 'config/config.php'; ?>
<?php include 'connections/Database.php'; ?>
<?php include 'helpers/helper.php'; ?>


<?php
// Create DB object
$db = new Database;

$query = "SELECT * FROM category";
// Run query
$category = $db->select($query);


$device = "";
$src_q = "";

if (isset($_GET['device']) || isset($_GET['q'])) {// Create query
    $device = $_GET['device'];
    $src_q = $_GET['q'];


    $query = "SELECT a.* FROM article AS a INNER JOIN category AS c ON a.category_id = c.id WHERE 1=1 ";

    $filterValues = array();

    if ($device !== "") {
        $query .= " AND c.name = '$device'";
    }

    if (strlen($src_q) >= 3 || strlen($src_q) == 0) {

        $query .= " AND (title LIKE '%" . $src_q . "%' OR text LIKE '%" . $src_q . "%')";
    } else {
        alert("Minimum serarcqhery is 3 characters!");

    }


} else {
    $query = "SELECT * FROM article LIMIT 4";

}
$article = $db->select($query);


$db->link->close();

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

        <!-- Searchbar -->
        <form class="grid-searchbar" action="" method="GET">
            <div class="selectors grid-selectors">
                <!-- Selectors -->
                <label>Device:</label>
                <select name="device">


                    <option value="" selected>All</option>


                    <?php if ($category) : ?>
                        <?php while ($row = $category->fetch_assoc()) : ?>
                            <option value="<?php echo $row['name']; ?>"
                                <?php
                                if ($row['name'] === $device) {
                                    echo 'selected';
                                }
                                ?>
                            >
                                <?php echo $row['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No categories yet</p>
                    <?php endif; ?>
                </select>
            </div>
            <input class="searchbar" type="text" name="q" placeholder="Search.." value="<?php if (!empty($src_q)) {
                echo $src_q;
            } ?>">
            <button class="categorieButton" type="submit" name="submit">
                Search
            </button>
        </form>
    </section>

    <section class="articles grid-sectionArticles">
        <!-- Template of an article -->
        <?php if ($article)  : ?>
            <?php while ($row = $article->fetch_assoc()) : ?>
                <article class="indexArticle ">
                    <!-- image side -->
                    <aside class="indexAside grid-firstHalf">
                        <a href="article.php?post=<?php echo $row['id']; ?>"><img class="articleImg" src="<?php ;
                            echo $row['cover'] ?>" alt="placeholder"></a>
                    </aside>
                    <!-- Description -->
                    <div class="grid-secondHalf article-text" id="overskrift">
                        <h1 class="articleHeader"><a href="article.php?post=<?php echo $row['id']; ?>">Header</a>
                        </h1>
                        <h4>
                            <?php echo shortenText($row['text']); ?>
                        </h4>
                        <h4 class="byline">
                            <small>written by <?php echo $row['author']; ?>
                                | <?php echo formatDate($row['published']); ?></small>
                        </h4>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>There are no posts matching the search criteria.</p>
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
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab debitis dicta explicabo fugit illum
                impedit
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
</html>