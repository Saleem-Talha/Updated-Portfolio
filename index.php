<?php 
    include 'includes/db-connect.php';
    include('includes/header-links.php');
    include('send-email.php');


// Fetch the latest description from the hero table
$description = '';
$result = $db->query("SELECT description FROM hero ORDER BY id  LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $description = $row['description'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the description from the textarea
    $new_description = $_POST['description'];

    // Prepare an SQL statement to insert the new description into the hero table
    $stmt = $db->prepare("INSERT INTO hero (description) VALUES (?)");
    if ($stmt) {
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $new_description);
        $stmt->execute();
        $stmt->close(); // Close the statement

        echo "<div class='alert alert-success' role='alert'>Data saved successfully!</div>";

        // Update the displayed description with the newly saved data
        $description = $new_description;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . $db->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>Saleem Talha Portfolio</title>
</head>

<body class="text-white">
    <div id="particles-container">
        <div id="particles-js"></div>
    </div>

    <?php 
    include_once('includes/navbar.php')
    ?>
    <section id="home">
        <div class="container" data-aos="fade-up" data-aos-delay="1000">
            <div class="row">
                <div class="col-md-8">
                    <div class="">
                        <p class="mb-3 main-text fs-1 white-opacity-50">Hi, my name is</p>
                        <h1 class="bold-text mb-3  fs-5">Saleem Talha</h1>
                        <h3 class="mb-3 fs-2">
                            I am a <span class="text-main" id="typing-effect"></span>
                        </h3>
                        <div class="card mb-3">
                            <div class="card-body ps-0 py-5">
                                <p class="text-start main-text  fs-1 white-opacity-50 mb-0">
                                   <?php echo $description; ?>
                                </p>
                                <a href="https://drive.google.com/file/d/1j0zs4pDJBRp0-2Omqm4_w4HpL5DEuwGC/view?usp=sharing"
                                    target="_blank">
                                    <button class="btn btn-outline-main mt-3 main-text me-3">
                                        Download
                                        CV
                                    </button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hide-on-mobile">
                        <ul class="social-links">
                            <li>
                                <a href="https://www.instagram.com/______talha_/" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/muhammad-saleem-talha?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app " target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/Saleem-Talha" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://mail.google.com/mail/u/0/#inbox?compose=CllgCJTMXgJFbZkGdZlLdQgCcVtjPmPnPhwVghMHjhqqRTrDLCbtXNcKgDSrkblhRvwZrhRRDqB"
                                    target="_blank">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.link/g4kggi" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <script>
            const phrases = [
                "Full Stack Developer Developer",
                "React Developer",
                "PHP Developer",
                ".NET Developer",
                "Flutter Developer",
                "Ui/UX Desinger",
            ];
            const typingElement = document.getElementById("typing-effect");

            function typeText(text, element, delay) {
                let index = 0;
                const interval = setInterval(() => {
                    element.textContent = text.slice(0, index);
                    index++;

                    if (index > text.length) {
                        clearInterval(interval);
                        setTimeout(() => {
                            eraseText(element);
                        }, delay);
                    }
                }, 100);
            }

            function eraseText(element) {
                const text = element.textContent;
                let index = text.length;
                const interval = setInterval(() => {
                    element.textContent = text.slice(0, index);
                    index--;

                    if (index < 0) {
                        clearInterval(interval);

                        // Move to the next phrase
                        const nextPhrase =
                            phrases[(phrases.indexOf(text) + 1) % phrases.length];
                        setTimeout(() => {
                            typeText(nextPhrase, element, 700);
                        }, 300);
                    }
                }, 80);
            }

            // Start typing effect
            typeText(phrases[0], typingElement, 1000);
        </script>
    </section>

    
    <?php include_once('about.php'); ?>
    <?php include_once('achievements.php'); ?>
    
    <?php include_once('skills.php'); ?>
    <?php include_once('services.php'); ?>
    <?php include_once('projects.php'); ?>
   
    <?php include_once('includes/footer.php'); ?>
    <?php include_once('particles.php'); ?>
    <?php include_once('echarts.php'); ?>
    <?php include_once('swiper.php'); ?>

    <script>
        AOS.init();
    </script>

    <div class="footer-design-develop bg-main p-5">
        <p class="text-center text-muted mb-0 main-text">
            Designed & Developed By
            <a href="#home" class="designed">© Saleem Talha</a>
        </p>
        <p class="text-center text-muted mb-0 main-text mt-2"> All Rights Reserved</p>
    </div>
</body>
</html>

<script>
        document.addEventListener('keydown', function(event) {
            if (event.altKey && event.shiftKey && event.key === 'A') {
                // Redirect to admin.php
                window.location.href = 'admin.php';
            }
            if (event.altKey && event.shiftKey && event.key === 'U') {
                // Redirect to admin.php
                window.location.href = 'update_project.php';
            }
        });
    </script>