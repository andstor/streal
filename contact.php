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

        <iframe class="GoogleDirectionMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d775.3256454650013!2d6.236603979850559!3d62.47162423509786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4616dac1b03a4a8b%3A0x5df22844dd93ce98!2sNTNU+i+%C3%85lesund!5e0!3m2!1sno!2sno!4v1521657351675"
                width="400" height="260" frameborder="0" style="border:0" allowfullscreen></iframe>
        <div class="contact-caption">Anything you want to contact us about? Or maybe it's something we can do better? We always want to improve. Just write a message and send it to us.</div>
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