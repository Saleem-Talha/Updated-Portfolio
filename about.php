<?php
include 'includes/db-connect.php';
include('includes/header-links.php');

// Fetch the latest description and image from the about table
$about_description = '';
$about_img = '';
$result = $db->query("SELECT description, about_img FROM about ORDER BY id DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $about_description = $row['description'];
    $about_img = $row['about_img'];
}
?>

<section class="about py-5" id="about">
    <p style="color: transparent;">h</p>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <figure data-aos="fade-up">
                    <blockquote class="blockquote">
                        <h2 class="text-main bold-text ">About Me.</h2>
                    </blockquote>
                    <figcaption class="blockquote-footer mb-0 fs-1 text-uppercase">
                        Section 02
                    </figcaption>
                </figure>
            </div>
            <div class="col-md-8 order-2 order-md-1 d-flex align-items-center" data-aos="fade-up">
                <div class="card">
                    <div class="card-body ps-0">
                        <p class="text-start main-text bold-text fs-1 mb-0 white-opacity-50">
                            <?php echo nl2br(htmlspecialchars($about_description)); ?>
                        </p>

                        <!-- Keep the existing static content -->
                        <ul class="main-text fs-1 mt-2 white-opacity-50">
                            <li>
                                Experience : <span style=" color: rgb(104, 222, 110);">3 years +</span>
                            </li>
                            <li>
                                Projects : <span style="color:  rgb(104, 222, 110);">30 +</span>
                            </li>
                        </ul>

                    
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-1 order-md-2" data-aos="fade-up">
                <div class="about-img">
                    <?php if (!empty($about_img)): ?>
                        <img src="<?php echo htmlspecialchars($about_img); ?>" alt="About Me" class="w-100" />
                    <?php else: ?>
                        <img src="img/about-pic.jpeg" alt="Default About Image" class="w-100" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>