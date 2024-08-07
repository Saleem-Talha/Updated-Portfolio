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
        gap: 10px;
        border: none;
        outline: none;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 12px;
        background-color: transparent;
        color: white;
        border: 1px solid white;
        font-size: 0.875rem;
        text-align: center;
    }

    .project-card {
        cursor: pointer;
        transition: transform 0.3s ease;
        height: 230px; /* Fixed height for the card */
        overflow: hidden; /* Hide overflow by default */
    }

    .project-card:hover {
        transform: translateY(-5px);
    }

    .card-body {
        display: flex;
        flex-direction: column;
        height: 100%; /* Full height for the body */
    }

    .card-text {
        flex: 1; /* Allow text to take available space */
        overflow: auto; /* Scrollable if content overflows */
        text-overflow: ellipsis;
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
                                    <div class="card mb-3 border border-main p-3 rounded-4 main-text project-card" data-aos="fade-up" onclick="window.location.href='project-details.php?id=<?php echo $project['id']; ?>'">
                                        <div class="row g-0">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center" style="height: 170px;">
                                                <div style="height: 180px; width: 180px; object-fit: cover;">
                                                    <img src="<?php echo htmlspecialchars($project['project_img']); ?>" class="img-fluid rounded-4" alt="<?php echo htmlspecialchars($project['project_name']); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body py-0">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                                                    <div class="card-text text-body-secondary">
                                                        <?php
                                                        // Limit description to a few words
                                                        $description = htmlspecialchars($project['project_description']);
                                                        $words = explode(' ', $description);
                                                        $short_description = implode(' ', array_slice($words, 0, 15)); // Adjust the number of words
                                                        echo $short_description . (count($words) > 15 ? '...' : '');
                                                        ?>
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between">
                                                        <div class="tech-badges-container">
                                                            <?php 
                                                            $technologies = explode("\n", $project['project_technologies']); // Split technologies by newline
                                                            foreach ($technologies as $tech): 
                                                                $tech = trim($tech);
                                                                if (!empty($tech)):
                                                            ?>
                                                                <span class="badge"><?php echo htmlspecialchars($tech); ?></span>
                                                            <?php
                                                                endif;
                                                            endforeach; ?>
                                                        </div>
                                                        <div class="git">
                                                            <a href="<?php echo htmlspecialchars($project['project_link']); ?>" style="text-decoration: none;" onclick="event.stopPropagation();">
                                                                <button class="btn btn-main btn-sm main-text px-3 mt-2">
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
