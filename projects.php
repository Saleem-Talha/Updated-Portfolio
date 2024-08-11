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
            gap: 5px;
            margin-bottom: 10px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.75rem;
            text-align: center;
        }

        .project-card {
            cursor: pointer;
            transition: transform 0.3s ease;
            height: 350px;
            overflow: hidden;
        }

        .project-card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .card-text {
            font-size: 0.9rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        @media (max-width: 768px) {
            .project-card {
                height: auto;
            }
        }
    </style>

    <section id="projects" class="py-5">
        <p style="color: transparent;">h</p>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure data-aos="fade-up">
                        <blockquote class="blockquote">
                            <h2 class="text-main bold-text">Projects.</h2>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0 fs-1 text-uppercase">
                            Section 05
                        </figcaption>
                    </figure>
                    
                    <p class="text-center white-opacity-50 fs-1 mt-2" data-aos="fade-up">Swipe to view other projects</p>
                </div>
            </div>
            <div class="row py-5" style="overflow: hidden">
                <div class="col-12">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php while ($project = $projects_result->fetch_assoc()): ?>
                                <div class="swiper-slide">
                                    <div class="card project-card border border-main rounded-4 main-text" data-aos="fade-up" onclick="window.location.href='project-details.php?id=<?php echo $project['id']; ?>'">
                                        <img src="<?php echo htmlspecialchars($project['project_img']); ?>" class="card-img-top rounded-top-4" alt="<?php echo htmlspecialchars($project['project_name']); ?>">
                                        <div class="card-body">
                                            <div class="tech-badges-container">
                                                <?php 
                                                $technologies = explode("\n", $project['project_technologies']);
                                                foreach ($technologies as $tech): 
                                                    $tech = trim($tech);
                                                    if (!empty($tech)):
                                                ?>
                                                    <span class="badge"><?php echo htmlspecialchars($tech); ?></span>
                                                <?php
                                                    endif;
                                                endforeach; 
                                                ?>
                                            </div>
                                            <h5 class="card-title"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                                            <p class="card-text text-body-secondary">
                                                <?php
                                                $description = htmlspecialchars($project['project_description']);
                                                echo substr($description, 0, 100) . (strlen($description) > 100 ? '...' : '');
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center white-opacity-50 fs-1 mt-3" data-aos="fade-up">Click on Projects to see the details</p>
        </div>
    </section>
<?php else: ?>
    <p>No projects found.</p>
<?php endif; ?>