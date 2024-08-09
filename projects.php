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
    height: 230px;
    overflow-y: auto;
}

.project-card:hover {
    transform: translateY(-5px);
}

.card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card-text {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.git {
    margin-top: auto;
}

@media (max-width: 1024px) {
    .project-card {
        height: 300px;
        max-height: 400px;
    }
    .card-body {
        padding: 1rem;
    }
    .row.g-0 {
        flex-direction: column;
    }
    .col-md-4, .col-md-8 {
        width: 100%;
    }
    .git {
        display: none;
    }
}

/* Responsive styles */
@media (max-width: 768px) {
    .project-card {
        height: auto;
        max-height: 400px;
    }
    .card-body {
        padding: 1rem;
    }
    .row.g-0 {
        flex-direction: column;
    }
    .col-md-4, .col-md-8 {
        width: 100%;
    }
    .git {
        display: none;
    }
}

/* Ensure card text is truncated in all sizes */
.card-text {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    max-height: 4.5em; /* Adjust this value based on your font size and line height */
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
                    
                    <p class="text-center white-opacity-50 fs-1 mt-2" data-aos="fade-up">Swpie to view other projects</p>
                </div>
            </div>
            <div class="row py-5" style="overflow: hidden">
                <div class="col-12">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php while ($project = $projects_result->fetch_assoc()): ?>
                                <div class="swiper-slide">
                                    <div class="card mb-3 border border-main p-3 rounded-4 main-text project-card" data-aos="fade-up" onclick="window.location.href='project-details.php?id=<?php echo $project['id']; ?>'">
                                        <div class="row g-0">
                                            <div class="col-md-4 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                                                <div style="height: 180px; width: 180px; overflow: hidden;">
                                                    <img src="<?php echo htmlspecialchars($project['project_img']); ?>" class="img-fluid rounded-4" alt="<?php echo htmlspecialchars($project['project_name']); ?>" style="object-fit: cover; width: 100%; height: 100%;" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body d-flex flex-column h-100">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                                                    <div class="card-text text-body-secondary">
                                                        <?php echo htmlspecialchars($project['project_description']); 
                                                         echo substr($description, 0, 100) . (strlen($description) > 100 ? '...' : '');?>
                                                        
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between">
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
                                                            endforeach; ?>
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
            <p class="text-center white-opacity-50 fs-1 mt-3" data-aos="fade-up">Click on Projects to see the details</p>
        </div>
    </section>
<?php else: ?>
    <p>No projects found.</p>
<?php endif; ?>