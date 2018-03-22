<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Streal</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/contact.css">
    <script type="text/javascript" src="scripts/main.js"></script>
</head>
<body>

<?php include_once 'includes/navbar.php' ?>


<main class="wrapper">
    <section class="grid-contact">
        <h1>Contact us</h1>

        <img class="contactIMG" src="http://via.placeholder.com/400x260" alt="placeholder">

        <div class="col-3-4">
            <form class="" action="mailto:andstorh@stud.ntnu.no?subject=Feedback" method="post"
                  enctype="text/plain">

                <fieldset>
                    <label>
                        <h6>Subject</h6>
                        <input class="contactFieldTitle" type="text" subject="subject" placeholder=""
                               required>
                    </label>

                    <label>
                        <h6>Message</h6>
                        <textarea class="contactFieldTitle" name="message" maxlength="500"></textarea>
                    </label>

                </fieldset>

                <button class="sendButton" type="button" name="button">
                    Send
                </button>
            </form>

        </div>
    </section>

    <!-- Featured Section -->
    <aside class="grid-sectionFeatured">

    </aside>

</main>

<?php include_once 'includes/footer.php' ?>


</body>
</html>