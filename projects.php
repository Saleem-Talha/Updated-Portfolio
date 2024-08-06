<?php
// Fetch projects from the database
$projects_result = $db->query("SELECT * FROM projects ORDER BY id DESC");
?>

<!-- Check if there are any projects -->
<?php if ($projects_result && $projects_result->num_rows > 0): ?>

    <style>
    .tech-badges-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Adds margin between badges */
        /* Ensure no border or outline is set on the container */
        border: none;
        outline: none;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 12px;
        background-color: transparent;
        color: white;
        border: 1px solid white; /* Optional: Adds a border to the badge itself */
        font-size: 0.875rem; /* Adjust as needed */
        text-align: center;
    }
    </style>

    <section id="projects" class="py-5">
        <p style="color: transparent;">h</p>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <figure data-aos="fade-up">
                        <blockquote class="blockquote">
                            <h2 class="text-main bold-text">Projects.</h2>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0 fs-1 text-uppercase">
                            Section 05
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="row py-5" style="overflow: hidden">
                <div class="">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php while ($project = $projects_result->fetch_assoc()): ?>
                                <div class="swiper-slide">
                                    <div class="card mb-3 border border-main p-3 rounded-4 main-text" data-aos="fade-up">
                                        <div class="row g-0">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center" style="height: 170px;">
                                                <div style="height: 180px; width: 180px; object-fit: cover;">
                                                    <img src="<?php echo htmlspecialchars($project['project_img']); ?>" class="img-fluid rounded-4" alt="<?php echo htmlspecialchars($project['project_name']); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body py-0">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                                                    <div style="height: 100px; overflow: auto" class="mobile-view-card">
                                                        <p class="text-body-secondary">
                                                            <?php echo htmlspecialchars($project['project_description']); ?>
                                                        </p>
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between">
                                                        <div class="tech-badges-container">
                                                            <?php 
                                                            // Display technologies as badges
                                                            $technologies = explode(", ", $project['project_technologies']);
                                                            foreach ($technologies as $tech): ?>
                                                                <span class="badge"><?php echo htmlspecialchars($tech); ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="git">
                                                            <a href="<?php echo htmlspecialchars($project['project_link']); ?>" style="text-decoration: none;">
                                                                <button class="btn btn-main btn-sm main-text px-3 mt-2">
                                                                    <!-- Use mt-2 for spacing -->
                                                                    Github
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <p>No projects found.</p>
<?php endif; ?>
