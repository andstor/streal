<?php include 'config/config.php'; ?>
<?php include 'connections/Database.php'; ?>

<?php
// Create DB object
$db = new Database;

// Filter (check URL for category)
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    // Create query
    $query = "SELECT *
                FROM article AS p
                WHERE p.category_id = " . $category;
    // Run query
    $article = $db->select($query);
} else {
    // Create query
    $query = "SELECT * FROM article";
    // Run query
    $article = $db->select($query);
}

// Create query
$query = "SELECT * FROM category";
// Run query
$category = $db->select($query);
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

    <section class="category grid-categorie">
        <div class="selectors grid-selectors">
            <!-- Selectors -->
            <label>Device:</label>
            <select name="Device">
                <option value="Placeholder" selected>---</option>
                <?php if ($category) : ?>
                    <?php while ($row = $category->fetch_assoc()) : ?>
                        <option>
                            <a href="blog.php?category=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                        </option>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No categories yet</p>
                <?php endif; ?>
            </select>
            <label>Price:</label>
            <select name="Price">
                <option value="Placeholder" selected>---</option>
                <option value="200">$200</option>
                <option value="500">$500</option>
                <option value="$1000">$1000</option>
            </select>
            <label>Rating:</label>
            <select name="Rating">
                <option value="Placeholder" selected>---</option>
                <option value="star-1">&#9773;</option>
                <option value="star-2">&#9773;&#9773;</option>
                <option value="star-3">&#9773;&#9773;&#9773;</option>
                <option value="star-4">&#9773;&#9773;&#9773;&#9773;</option>
                <option value="star-5">&#9773;&#9773;&#9773;&#9773;&#9773;</option>
            </select>
        </div>
        <!-- Button for searching -->
        <button class="categorieButton" type="button" name="button">
            Search
        </button>
        <!-- Searchbar -->
        <form class="grid-searchbar" action="" method="GET">
            <input class="searchbar" type="text" name="q" placeholder="Search..">
        </form>
    </section>

</main>


<main class="exampleWidth wrapper">

    <section class="articles grid-sectionArticles">
        <!-- Template of an article -->
        <?php if ($article) : ?>
            <?php while ($row = $article->fetch_assoc()) : ?>
                <article class="indexArticle wrapper" onmouseout="staticText()" onmouseover="hoverText()">
                    <a href="article.php?id=<?php echo $row['id']; ?>">
                    <!-- image side -->
                    <aside class="indexAside grid-firstHalf">
                        <img class="articleImg" src="http://via.placeholder.com/400x260" alt="placeholder">
                    </aside>
                    <!-- Description -->
                    <div class="grid-secondHalf article-text" id="overskrift">
                        <h1 class="articleHeader"><a href="#">Header</a></h1>
                        <h4>
                            <?php echo shortenText($row['text']); ?>
                        </h4>
                        <h4 class="byline">
                            <small>written by <?php echo $row['author']; ?> | <?php echo formatDate($row['published']); ?></small>
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

</body>
</html>